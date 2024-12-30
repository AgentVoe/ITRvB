<?php
namespace App\Services;

use App\Models\CommentLike;
use App\Repositories\CommentLikesRepository;
use Ramsey\Uuid\Uuid;
use Exception;

class CreateCommentLike
{
    private CommentLikesRepository $repository;

    public function __construct(CommentLikesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createLike(array $data): array
    {
        if (empty($data['author_uuid']) || empty($data['comment_uuid']))
        {
            return ['status' => 'error', 'message' => 'Missing data'];
        }

        if (!Uuid::isValid($data['author_uuid']) || !Uuid::isValid($data['comment_uuid']))
        {
            return ['status' => 'error', 'message' => 'Invalid UUID'];
        }

        try
        {
            $commentLike = new CommentLike(Uuid::uuid4(), Uuid::fromString($data['comment_uuid']), Uuid::fromString($data['author_uuid']));
            $this->repository->save($commentLike);
            return ['status' => 'success', 'message' => 'CommentLike created'];
        }
        catch(Exception $e)
        {
            return ['status' => 'error', 'message' => 'Error saving'];
        }
    }
}
?>