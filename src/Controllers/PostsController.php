<?php
namespace App\Controllers;

use App\Repositories\PostsRepository;
use App\Services\CreatePost;
use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PostsController
{
    private CreatePost $createPost;

    public function __construct()
    {
        $db = new PDO('sqlite:database.sqlite');
        $postsRepository = new PostsRepository($db);
        $this->createPost = new CreatePost($postsRepository);
    }

    public function create(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if(empty($data))
        {
            $result = ['status' => 'error', 'message' => 'Missing data'];
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = $this->createPost->create($data);

        $response->getBody()->write(json_encode($result));

        if ($result['status'] === 'error')
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function delete(Request $request, Response $response)
    {
        $uuid = $request->getQueryParams()['uuid'] ?? null;

        if(!$uuid)
        {
            $result = ['status' => 'error', 'message' => 'Missing UUID'];
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = $this->createPost->delete($uuid);
        $response->getBody()->write(json_encode($result));

        if ($result['status'] === 'error')
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>