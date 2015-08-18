CREATE TABLE users (
id int not null auto_increment PRIMARY KEY ,
user_login varchar(60) not null ,
user_nickname varchar(60) not null ,
user_registered  TIMESTAMP default CURRENT_TIMESTAMP
)