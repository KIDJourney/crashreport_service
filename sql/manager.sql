CREATE TABLE manager (
    id int not null  primary key auto_increment , 
    manager_login varchar(60) not null UNIQUE , 
    manager_passwd varchar(32) not null , 
    manager_registered timestamp not null default current_timestamp 
)