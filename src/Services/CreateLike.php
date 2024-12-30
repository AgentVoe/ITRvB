<?php
namespace App\Services;

use App\Models\PostLike;
use App\Repositories\PostLikesRepository;
use Ramsey\Uuid\Uuid;
use Exception;

class CreateLike
{
    private PostLikesRepository $repository;

    public function __construct(PostLikesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createLike(array $data): array
    {
        if (empty($data['author_uuid']) || empty($data['post_uuid']))
        {
            return ['status' => 'error', 'message' => 'Missing data'];
        }

        if (!Uuid::isValid($data['author_uuid']) || !Uuid::isValid($data['post_uuid']))
        {
            return ['status' => 'error', 'message' => 'Invalid UUID'];
        }

        try
        {
            $postLike = new PostLike(Uuid::uuid4(), Uuid::fromString($data['post_uuid']), Uuid::fromString($data['author_uuid']));
            $this->repository->save($postLike);
            return ['status' => 'success', 'message' => 'PostLike created'];
        }
        catch(Exception $e)
        {
            return ['status' => 'error', 'message' => 'Error saving'];
        }
    }
}
?>