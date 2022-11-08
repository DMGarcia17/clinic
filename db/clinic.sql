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

Create table clinics (
	cod_clinic int auto_increment primary key,
	clinic_name varchar(200),
	address varchar(1000),
	phone_number varchar(15)
);