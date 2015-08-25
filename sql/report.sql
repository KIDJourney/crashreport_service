CREATE TABLE report (
id int not null auto_increment PRIMARY  key ,
report_pos int not null ,
report_info varchar(128) ,
report_type INT NOT NULL ,
report_picurl varchar(128) ,
report_status TINYINT not null DEFAULT 0 ,
report_fixerid int DEFAULT 0 ,
report_reporter int not null ,
report_createat timestamp default CURRENT_TIMESTAMP ,
report_endat timestamp
)
