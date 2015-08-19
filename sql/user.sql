CREATE TABLE users (
id int not null auto_increment PRIMARY KEY ,
user_login varchar(60) not null ,
user_passwd VARCHAR( 32 ) NOT NULL ,
user_name varchar(60) not null ,
user_tel VARCHAR( 12 ) NOT NULL AFTER
user_registered  TIMESTAMP default CURRENT_TIMESTAMP
)
