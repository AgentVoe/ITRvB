CREATE TABLE posts (
    uuid TEXT PRIMARY KEY,
    author_uuid TEXT,
    title TEXT,
    text TEXT,
    FOREIGN KEY (author_uuid) REFERENCES users (uuid)
);

CREATE TABLE comments (
    uuid TEXT PRIMARY KEY,
    post_uuid TEXT,
    author_uuid TEXT,
    text TEXT,
    FOREIGN KEY (post_uuid) REFERENCES posts (uuid),
    FOREIGN KEY (author_uuid) REFERENCES users (uuid)
);

CREATE TABLE users (
    uuid TEXT PRIMARY KEY,
    username TEXT,
    first_name TEXT,
    last_name TEXT
); 

CREATE TABLE posts_likes(
    uuid TEXT PRIMARY KEY,
    post_uuid TEXT,
    author_uuid TEXT,
    UNIQUE(post_uuid, author_uuid),
    FOREIGN KEY (post_uuid) REFERENCES posts (uuid),
    FOREIGN KEY (author_uuid) REFERENCES users (uuid)
);
CREATE TABLE comments_likes(
    uuid TEXT PRIMARY KEY,
    comment_uuid TEXT,
    author_uuid TEXT,
    UNIQUE(comment_uuid, author_uuid),
    FOREIGN KEY (comment_uuid) REFERENCES comments (uuid),
    FOREIGN KEY (author_uuid) REFERENCES users (uuid)
);