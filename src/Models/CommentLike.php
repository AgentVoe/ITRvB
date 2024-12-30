<?php
namespace App\Models;

use Ramsey\Uuid\UuidInterface;

class CommentLike
{
    public UuidInterface $uuid;
    public UuidInterface $commentUuid;
    public UuidInterface $authorUuid;

    public function __construct(UuidInterface $uuid, UuidInterface $commentUuid, UuidInterface $authorUuid)
    {
        $this->uuid = $uuid;
        $this->commentUuid = $commentUuid;
        $this->authorUuid = $authorUuid ;
    }
}

?>