<?php
namespace App\Controllers;

use App\Services\CreateCommentLike;
use App\Repositories\CommentLikesRepository;
use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CommentLikesController
{
    private CreateCommentLike $createLike;

    public function __construct()
    {
        $logger = new Logger('commentLikes');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app.log', Logger::INFO));
        $db = new PDO('sqlite:database.sqlite');
        $likesRepository = new CommentLikesRepository($db, $logger);
        $this->createLike = new CreateCommentLike($likesRepository);
    }

    public function createCommentLike(Request $request, Response $response)
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