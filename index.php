<?php

require 'vendor/autoload.php';

use App\Controllers\CommentLikesController;
use App\Controllers\PostsController;
use App\Controllers\CommentsController;
use App\Controllers\LikesController;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->post('/posts', [PostsController::class, 'create']);
$app->post('/posts/comment', [CommentsController::class, 'create']);
$app->delete('/posts', [PostsController::class, 'delete']);
$app->delete('/posts/comment', [CommentsController::class, 'delete']);

$app->post('/posts/like', [LikesController::class, 'createPostLike']);
$app->post('/comments/like', [CommentLikesController::class, 'createCommentLike']);

$app->run();
?>