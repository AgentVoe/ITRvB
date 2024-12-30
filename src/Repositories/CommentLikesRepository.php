<?php
namespace App\Repositories;

use App\Models\CommentLike;
use App\Repositories\Interfaces\ICommentLikesRepository;
use PDO;
use Psr\Log\LoggerInterface;

class CommentLikesRepository implements ICommentLikesRepository
{
    private PDO $db;
    private LoggerInterface $logger;

    public function __construct(PDO $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function save(CommentLike $like): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO comments_likes (uuid, comment_uuid, author_uuid) VALUES (:uuid, :comment_uuid, :author_uuid)'
        );
        $stmt->execute([
            'uuid' => $like->uuid,
            'comment_uuid' => $like->commentUuid,
            'author_uuid' => $like->authorUuid,
        ]);

        $this->logger->info('Лайк добавлен', ['postUuid' => $like->uuid->toString()]);
    }

    public function getByCommentUuid(string $commentUuid): array
    {
        $stmt = $this->db->prepare('SELECT * FROM comments_likes WHERE comment_uuid = :comment_uuid');
        $stmt->execute(['comment_uuid' => $commentUuid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>