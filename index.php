<?php

require 'vendor/autoload.php';

use App\Models\Post;
use App\Models\Comment;
use App\Repositories\PostsRepository;
use App\Repositories\CommentsRepository;
use Ramsey\Uuid\Uuid;
use Faker\Factory;

$faker = Factory::create();

$db = new PDO('sqlite:database.sqlite');

$postsRepository = new PostsRepository($db);

$post = new Post(Uuid::uuid4(), Uuid::uuid4(), 'Title', 'Text');

$postsRepository->save($post);
$getPost = $postsRepository->get($post->uuid->toString());

echo "post Id = {$getPost->uuid} post Title = {$getPost->title}<br>";

$commentsRepository = new CommentsRepository($db);

$comment = new Comment(Uuid::uuid4(), Uuid::uuid4(), Uuid::uuid4(), 'Text');

$commentsRepository->save($comment);
$getComment = $commentsRepository->get($comment->uuid->toString());

echo "comment Id = {$getComment->uuid} comment Text = {$getComment->text}<br>";
?>