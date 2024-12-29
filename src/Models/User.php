<?php
namespace App\Models;

use Ramsey\Uuid\UuidInterface;

class User
{
    public UuidInterface $uuid;
    public string $userName;
    public string $firstName;
    public string $lastName;

    public function __construct(UuidInterface $uuid, string $userName, string $firstName, string $lastName)
    {
        $this->uuid = $uuid;
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}

?>