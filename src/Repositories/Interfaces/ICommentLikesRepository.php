<?php
namespace App\Repositories\Interfaces;

use App\Models\CommentLike;

interface ICommentLikesRepository
{
    public function save(CommentLike $like): void;
    public function getByCommentUuid(string $commentUuid): array;
}
?>