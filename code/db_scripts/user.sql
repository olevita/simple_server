create table IF NOT EXISTS user
(
    id       int primary key auto_increment,
    login    varchar(256) not null unique,
    password varchar(256) not null
);