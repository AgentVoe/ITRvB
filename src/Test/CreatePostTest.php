<?php

use PHPUnit\Framework\TestCase;
use App\Services\CreatePost;
use App\Repositories\PostsRepository;
use App\Models\Post;
use Ramsey\Uuid\Uuid;
use App\Test\TestLogger;

class CreatePostTest extends TestCase {
    private CreatePost $service;

    protected function setUp(): void {
        $db = new PDO('sqlite::memory:');
        $db->exec("
            CREATE TABLE posts (
                uuid TEXT PRIMARY KEY,
                author_uuid TEXT,
                title TEXT,
                text TEXT
            );
        ");

        $this->service = new CreatePost(new PostsRepository($db, new TestLogger()));
    }

    public function testReturnsSuccessResponse(): void
    {
        $data = ['author_uuid' => Uuid::uuid4()->toString(), 'title' => 'title', 'text' => 'text'];

        $result = $this->service->create($data);
        $this->assertEquals('success', $result['status']);
    }
    
    public function testReturnsErrorInvalidUUIDFormat(): void
    {
        $data = ['author_uuid' => 'InvalidUUID', 'title' => 'title', 'text' => 'text'];

        $result = $this->service->create($data);
        $this->assertEquals('Invalid UUID', $result['message']);
    }
    
    public function testReturnWhenDataIsMissing(): void
    {
        $data = ['author_uuid' => 'InvalidUUID', 'title' => 'title']; //Нет текста

        $result = $this->service->create($data);
        $this->assertEquals('Missing data', $result['message']);
    }
}
?>