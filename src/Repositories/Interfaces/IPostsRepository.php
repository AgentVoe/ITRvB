<?php
namespace App\Repositories\Interfaces;

use App\Models\Post;

interface IPostsRepository
{
    public function get(string $uuid): ?Post; 
    public function save(Post $comment): void; 
}
?>