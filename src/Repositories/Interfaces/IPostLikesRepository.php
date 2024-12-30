<?php
namespace App\Repositories\Interfaces;

use App\Models\PostLike;

interface IPostLikesRepository
{
    public function save(PostLike $like): void;
    public function getByPostUuid(string $postUuid): array;
}
?>