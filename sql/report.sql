CREATE TABLE report (
id int not null auto_increment PRIMARY  key ,
report_pos int not null ,
report_info varchar(128) ,
report_picurl varchar(128) ,
report_status TINYINT not null ,
report_fixerid int not null ,
report_reporter int not null ,
report_createat timestamp default CURRENT_TIMESTAMP ,
report_endat timestamp
)