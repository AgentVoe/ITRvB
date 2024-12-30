<?php
namespace App\Controllers;

use App\Services\CreateLike;
use App\Repositories\PostLikesRepository;
use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LikesController
{
    private CreateLike $createLike;

    public function __construct()
    {
        $db = new PDO('sqlite:database.sqlite');
        $likesRepository = new PostLikesRepository($db);
        $this->createLike = new CreateLike($likesRepository);
    }

    public function createPostLike(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (empty($data))
        {
            $result = ['status' => 'error', 'message' => 'Missing data'];
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $result = $this->createLike->createLike($data);
        $response->getBody()->write(json_encode($result));

        if ($result['status'] === 'error')
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}
?>