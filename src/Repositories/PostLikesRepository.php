<?php
namespace App\Repositories;

use App\Models\PostLike;
use App\Repositories\Interfaces\IPostLikesRepository;
use PDO;

class PostLikesRepository implements IPostLikesRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(PostLike $like): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts_likes (uuid, post_uuid, author_uuid) VALUES (:uuid, :post_uuid, :author_uuid)'
        );
        $stmt->execute([
            'uuid' => $like->uuid,
            'post_uuid' => $like->postUuid,
            'author_uuid' => $like->authorUuid,
        ]);
    }

    public function getByPostUuid(string $postUuid): array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts_likes WHERE post_uuid = :post_uuid');
        $stmt->execute(['post_uuid' => $postUuid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>