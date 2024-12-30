<?php
namespace App\Controllers;

use App\Repositories\CommentsRepository;
use App\Services\CreateComment;
use PDO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CommentsController
{
    private CreateComment $createComment;

    public function __construct()
    {
        $logger = new Logger('comments');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app.log', Logger::INFO));
        $db = new PDO('sqlite:database.sqlite');
        $commentsRepository = new CommentsRepository($db, $logger);
        $this->createComment = new CreateComment($commentsRepository);
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

        $result = $this->createComment->create($data);

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

        $result = $this->createComment->delete($uuid);
        $response->getBody()->write(json_encode($result));

        if ($result['status'] === 'error')
        {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>