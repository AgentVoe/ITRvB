<?php
namespace App\Repositories;

use PDO;
use App\Models\Post;
use App\Repositories\Interfaces\IPostsRepository;
use Ramsey\Uuid\Uuid;
use Exception;
use Psr\Log\LoggerInterface;

class PostsRepository implements IPostsRepository
{
    private PDO $db;
    private LoggerInterface $logger;

    public function __construct(PDO $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function get(string $uuid): ?Post 
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE uuid = :uuid');
        $stmt->execute(['uuid' => $uuid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $this->logger->warning('Пост не найден', ['postUuid' => $uuid]);
            throw new Exception('Пост не найден');
        }

        return new Post(Uuid::fromString($row['uuid']), Uuid::fromString($row['author_uuid']), $row['title'], $row['text']);
    }

    public function save(Post $post): void 
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text) VALUES (:id, :author, :title, :text)'
        );
        $stmt->execute([
            'id' => $post->uuid->toString(),
            'author' => $post->authorUuid->toString(),
            'title' => $post->title,
            'text' => $post->text,
        ]);

        $this->logger->info('Пост сохранен', ['postUuid' => $post->uuid->toString()]);
    }

    public function delete (string $uuid): void
    {
        $stmt = $this->db->prepare('DELETE FROM posts WHERE uuid = :uuid');
        $stmt->execute([
            'uuid' => $uuid
        ]);

        if ($stmt->rowCount() === 0)
        {
            $this->logger->warning('Пост не найден', ['postUuid' => $uuid]);
            throw new Exception('Post not found');
        }
    }
}
?>