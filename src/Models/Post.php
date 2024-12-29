<?php
namespace App\Models;

use Ramsey\Uuid\UuidInterface;

class Post
{
    public UuidInterface $uuid;
    public UuidInterface $authorUuid;
    public string $title;
    public string $text;

    public function __construct(UuidInterface $uuid, UuidInterface $authorUuid, string $title, string $text)
    {
        $this->uuid = $uuid;
        $this->authorUuid = $authorUuid;
        $this->title = $title;
        $this->text = $text;
    }
}

?>