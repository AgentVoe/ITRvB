<?php
namespace App\Models;

use Ramsey\Uuid\UuidInterface;

class Comment
{
    public UuidInterface $uuid;
    public UuidInterface $postUuid;
    public UuidInterface $authorUuid;
    public string $text;

    public function __construct(UuidInterface $uuid, UuidInterface $postUuid, UuidInterface $authorUuid, string $text)
    {
        $this->uuid = $uuid;
        $this->postUuid = $postUuid;
        $this->authorUuid = $authorUuid;
        $this->text = $text;
    }
}

?>