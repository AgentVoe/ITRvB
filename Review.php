<?php

class Review {
    public User $author;
    public string $comment;
    public int $rating;

    public function __construct(User $author, string $comment, int $rating) {
        $this->author = $author;
        $this->comment = $comment;
        $this->rating = $rating;
    }
}
?>