create database clinic;
use clinic;

create table users (
	username varchar(20) not null primary key,
	password varchar(70),
	complete_name varchar(20),
	cod_rol varchar(10),
	add_date timestamp,
	user_add varchar(20),
	mod_date timestamp,
	user_mod timestamp,
	last_pass_up timestamp
);