<?php
namespace App\Services;

use App\Repositories\CommentsRepository;
use App\Models\Comment;
use Ramsey\Uuid\Uuid;
use Exception;

class CreateComment
{
private CommentsRepository $commentsRepository;

    public function __construct(CommentsRepository $repository)
    {
        $this->commentsRepository = $repository;
    }

    public function create (array $data): array
    {
        if (empty($data['post_uuid']) || empty($data['author_uuid']) || empty($data['text']))
        {
            return ['status' => 'error', 'message' => 'Missing data'];
        }

        if (!Uuid::isValid($data['author_uuid']) || !Uuid::isValid($data['post_uuid']))
        {
            return ['status' => 'error', 'message' => 'Invalid UUID'];
        }

        try
        {
            $comment = new Comment(Uuid::uuid4(), Uuid::fromString($data['post_uuid']), Uuid::fromString($data['author_uuid']), $data['text']);
            $this->commentsRepository->save($comment);
            return ['status' => 'success', 'message' => 'Comment created'];
        } 
        catch(Exception $e)
        {
            return ['status' => 'error', 'message' => 'Error saving comment'];
        }
    }

    public function delete(string $uuid): array
    {
        try
        {
            $this->commentsRepository->delete($uuid);
            return ['status' => 'success', 'message' => 'Comment deleted'];
        }
        catch(Exception $e)
        {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
?>