<?php
namespace App\Models;

use Ramsey\Uuid\UuidInterface;

class PostLike
{
    public UuidInterface $uuid;
    public UuidInterface $postUuid;
    public UuidInterface $authorUuid;

    public function __construct(UuidInterface $uuid, UuidInterface $postUuid, UuidInterface $authorUuid)
    {
        $this->uuid = $uuid;
        $this->postUuid = $postUuid;
        $this->authorUuid = $authorUuid ;
    }
}

?>