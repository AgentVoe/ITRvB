<?php

use PHPUnit\Framework\TestCase;
use App\Repositories\PostsRepository;
use App\Models\Post;
use Ramsey\Uuid\Uuid;

class PostsRepositoryTest extends TestCase {
    private PDO $db;

    protected function setUp(): void {
        $this->db = new PDO('sqlite::memory:');
        $this->db->exec("
            CREATE TABLE posts (
                uuid TEXT PRIMARY KEY,
                author_uuid TEXT,
                title TEXT,
                text TEXT
            );
        ");
    }

    public function testPostIsSavedToRepository(): void {
        $repository = new PostsRepository($this->db);
        $post = new Post(Uuid::uuid4(), Uuid::uuid4(), 'Test Title', 'Test text');

        $repository->save($post);

        $stmt = $this->db->query("SELECT * FROM posts");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertSame($post->uuid->toString(), $result['uuid']);
        $this->assertSame($post->authorUuid->toString(), $result['author_uuid']);
        $this->assertSame($post->title, $result['title']);
        $this->assertSame($post->text, $result['text']);
    }

    public function testPostCanBeRetrievedByUUID(): void {
        $repository = new PostsRepository($this->db);
        $post = new Post(Uuid::uuid4(), Uuid::uuid4(), 'Test Title', 'Test Content');

        $repository->save($post);

        $retrievedPost = $repository->get($post->uuid->toString());

        $this->assertEquals($post, $retrievedPost);
    }

    public function testExceptionThrownIfPostNotFound(): void {
        $this->expectException(Exception::class);

        $repository = new PostsRepository($this->db);
        $repository->get(Uuid::uuid4()->toString());
    }
}
?>