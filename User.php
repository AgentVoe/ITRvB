<?php

class User {
    public string $username;
    public string $email;
    private string $password;

    public function __construct(string $username, string $email, string $password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function checkPassword(string $password): bool {
        return password_verify($password, $this->password);
    }
}

?>