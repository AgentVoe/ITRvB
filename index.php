<?php

require 'vendor/autoload.php';

use App\Controllers\PostsController;
use App\Controllers\CommentsController;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->post('/posts', [PostsController::class, 'create']);
$app->post('/posts/comment', [CommentsController::class, 'create']);
$app->delete('/posts', [PostsController::class, 'delete']);
$app->delete('/posts/comment', [CommentsController::class, 'delete']);

$app->run();
?>