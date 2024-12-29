<?php
namespace App\Repositories\Interfaces;

use App\Models\Comment;

interface ICommentsRepository
{
    public function get(string $uuid): ?Comment; 
    public function save(Comment $comment): void; 
}
?>