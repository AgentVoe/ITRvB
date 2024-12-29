<?php
namespace App;

class Comment
{
    public int $id;
    public int $authorId;
    public int $articleId;
    public string $text;
}

?>