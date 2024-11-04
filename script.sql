create database residencial;

use residencial;

create table users(
    id bigint primary key AUTO_INCREMENT,
    username varchar(13) not null unique ,
    email varchar(150) not null unique ,
    pass varchar(200) not null,
    rol enum('s_admin', 'admin', 'resident') default 'resident' not null
);