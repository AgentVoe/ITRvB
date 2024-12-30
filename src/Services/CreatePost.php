<?php
namespace App\Services;

use App\Repositories\PostsRepository;
use App\Models\Post;
use Ramsey\Uuid\Uuid;
use Exception;

class CreatePost
{
private PostsRepository $postsRepository;

    public function __construct(PostsRepository $repository)
    {
        $this->postsRepository = $repository;
    }

    public function create (array $data): array
    {
        if (empty($data['author_uuid']) || empty($data['title']) || empty($data['text']))
        {
            return ['status' => 'error', 'message' => 'Missing data'];
        }

        if (!Uuid::isValid($data['author_uuid']))
        {
            return ['status' => 'error', 'message' => 'Invalid UUID'];
        }

        try
        {
            $post = new Post(Uuid::uuid4(), Uuid::fromString($data['author_uuid']), $data['title'], $data['text']);
            $this->postsRepository->save($post);
            return ['status' => 'success', 'message' => 'Post created'];
        } 
        catch(Exception $e)
        {
            return ['status' => 'error', 'message' => 'Error saving post'];
        }
    }

    public function delete(string $uuid): array
    {
        try
        {
            $this->postsRepository->delete($uuid);
            return ['status' => 'success', 'message' => 'Post deleted'];
        }
        catch(Exception $e)
        {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
?>