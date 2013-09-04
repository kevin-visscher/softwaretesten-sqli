DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INTEGER primary key,
    username varchar(255),
    password varchar(255)
);