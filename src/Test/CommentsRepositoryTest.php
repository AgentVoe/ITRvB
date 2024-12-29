<?php

use PHPUnit\Framework\TestCase;
use App\Repositories\CommentsRepository;
use App\Models\Comment;
use Ramsey\Uuid\Uuid;

class CommentsRepositoryTest extends TestCase {
    private PDO $db;

    protected function setUp(): void {
        $this->db = new PDO('sqlite::memory:');
        $this->db->exec("
            CREATE TABLE comments (
                uuid TEXT PRIMARY KEY,
                post_uuid TEXT,
                author_uuid TEXT,
                text TEXT,
                FOREIGN KEY (post_uuid) REFERENCES posts (uuid),
                FOREIGN KEY (author_uuid) REFERENCES users (uuid)
            );
        ");
    }

    public function testCommentIsSavedToRepository(): void {
        $repository = new CommentsRepository($this->db);
        $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Test text');

        $repository->save($comment);

        $stmt = $this->db->query("SELECT * FROM comments");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertSame($comment->uuid->toString(), $result['uuid']);
        $this->assertSame($comment->postUuid->toString(), $result['post_uuid']);
        $this->assertSame($comment->authorUuid->toString(), $result['author_uuid']);
        $this->assertSame($comment->text, $result['text']);
    }

    public function testCommentCanBeRetrievedByUUID(): void {
        $repository = new CommentsRepository($this->db);
        $comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Test text');

        $repository->save($comment);

        $retrievedPost = $repository->get($comment->uuid->toString());

        $this->assertEquals($comment, $retrievedPost);
    }

    public function testExceptionThrownIfCOMMENTNotFound(): void {
        $this->expectException(Exception::class);

        $repository = new CommentsRepository($this->db);
        $repository->get(Uuid::uuid4()->toString());
    }
}
?>