<?php
namespace App\Repositories;

use PDO;
use App\Models\Comment;
use App\Repositories\Interfaces\ICommentsRepository;
use Ramsey\Uuid\Uuid;
use Exception;
use Psr\Log\LoggerInterface;

class CommentsRepository implements ICommentsRepository
{
    private PDO $db;
    private LoggerInterface $logger;

    public function __construct(PDO $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function get(string $uuid): ?Comment 
    {
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE uuid = :uuid');
        $stmt->execute(['uuid' => $uuid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $this->logger->warning('Комментарий не найден', ['postUuid' => $uuid]);
            throw new Exception('Комментарий не найден');
        }

        return new Comment(Uuid::fromString($row['uuid']), Uuid::fromString($row['post_uuid']), Uuid::fromString($row['author_uuid']), $row['text']);
    }

    public function save(Comment $comment): void 
    {
        $stmt = $this->db->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text) VALUES (:id, :post, :author, :text)'
        );
        $stmt->execute([
            'id' => $comment->uuid->toString(),
            'post' => $comment->postUuid->toString(),
            'author' => $comment->authorUuid->toString(),
            'text' => $comment->text,
        ]);

        $this->logger->info('Комментарий сохранен', ['postUuid' => $comment->uuid->toString()]);
    }

    public function delete (string $uuid): void
    {
        $stmt = $this->db->prepare('DELETE FROM comments WHERE uuid = :uuid');
        $stmt->execute([
            'uuid' => $uuid
        ]);

        if ($stmt->rowCount() === 0)
        {
            $this->logger->warning('Комментарий не найден', ['postUuid' => $uuid]);
            throw new Exception('Comment not found');
        }
    }
}
?>