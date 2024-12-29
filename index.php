<?php

require 'vendor/autoload.php';

use App\User;
use App\Article;
use App\Comment;
use Faker\Factory;

$faker = Factory::create();

// Генерация примеров пользователей
$user = new User();
$user->id = 1;
$user->firstName = $faker->firstName;
$user->lastName = $faker->lastName;

// Вывод данных
echo "User: {$user->id}, {$user->firstName} {$user->lastName}\n";

$article = new Article();
$article->id = 1;
$article->authorId = $user->id;
$article->title = $faker->sentence;
$article->text = $faker->paragraph;

echo "Article: {$article->id}, {$article->title}\n";

$comment = new Comment();
$comment->id = 1;
$comment->authorId = $user->id;
$comment->articleId = $article->id;
$comment->text = $faker->sentence;

echo "Comment: {$comment->id}, {$comment->text}\n";

?>