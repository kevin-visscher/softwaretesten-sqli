CREATE TABLE users IF NOT EXISTS (
    id INTEGER primary key,
    username varchar(255),
    password varchar(255)
);

CREATE TABLE messages IF NOT EXIST (
    id INTEGER PRIMARY KEY,
    message TEXT
);