CREATE TABLE IF NOT EXISTS users (
    id INTEGER primary key,
    username varchar(255),
    password varchar(255)
);

CREATE TABLE IF NOT EXISTS messages (
    id INTEGER PRIMARY KEY,
    message TEXT
);