<?php
namespace App\Repositories;

use PDO;
use App\Models\Comment;
use App\Repositories\Interfaces\ICommentsRepository;
use Ramsey\Uuid\Uuid;
use Exception;

class CommentsRepository implements ICommentsRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function get(string $uuid): ?Comment {
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE uuid = :uuid');
        $stmt->execute(['uuid' => $uuid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception('Комментарий не найден');
        }

        return new Comment(Uuid::fromString($row['uuid']), Uuid::fromString($row['post_uuid']), Uuid::fromString($row['author_uuid']), $row['text']);
    }

    public function save(Comment $comment): void {
        $stmt = $this->db->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text) VALUES (:id, :post, :author, :text)'
        );
        $stmt->execute([
            'id' => $comment->uuid->toString(),
            'post' => $comment->postUuid->toString(),
            'author' => $comment->authorUuid->toString(),
            'text' => $comment->text,
        ]);
    }
}
?>