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

create table diseases(
	cod_disease int auto_increment primary key,
	name varchar(500),
	pr_order int,
	description varchar(500)
);

create table allergies(
	cod_allergie int auto_increment primary key,
	name varchar(500),
	pr_order int,
	description varchar(500)
);

create table treatments(
	cod_treatment int auto_increment primary key,
	name varchar(500),
	pr_order int,
	description varchar(500),
	show_rp varchar(1) default 'N',
	paediatric_treatment varchar(1) default 'N'
);

create table medical_conditions (
	cod_medical int auto_increment primary key,
	question varchar(500),
	question_type varchar(10)
);

create table patients(
	cod_patient int auto_increment primary key,
	first_name varchar(50),
	second_name varchar(50),
	first_surname varchar(50),
	second_surname varchar(50),
	phone_number varchar(15),
	cellphone_numer varchar(15),
	address varchar(250),
	city varchar(250),
	state varchar(250),
	postal_code varchar(6),
	occupation varchar(250),
	height int,
	weight int,
	birthday date,
	gender varchar(1) comment "F female M male",
	num_id_patient varchar(15),
	emergency_call varchar(250),
	related varchar(50),
	phone_emergency varchar(15),
	cellphone_emergency varchar(15),
	filled_by varchar(250),
	related_fb varchar(50),
	doctors_care varchar(2) comment "S Si N No NS No se",
	doctors_name varchar(250),
	doctors_phone varchar(15),
	doctors_address varchar(250),
	doctors_city varchar(250),
	doctors_state varchar(250),
	doctors_zip varchar(6),
	healthy_patients varchar(2) comment "S Si N No NS No se",
	stable_health varchar(2) comment "S Si N No NS No se",
	doctors_condition varchar(500),
	exams_date date,
	past_years varchar(2) comment "S Si N No NS No se",
	disease_past varchar(250),
	taken_medicine varchar(2) comment "S Si N No NS No se",
	medicine varchar(500),
	antibiotics varchar(2) comment "S Si N No NS No se",
	antibiotics_doctor varchar(500),
	antibiotics_telephone varchar(15),
	disease_extra varchar(500),
	comentarios varchar(1000)
);

create table answer_mq (
	cod_patient int,
	cod_question int,
	answer varchar(2),
	unique(cod_patient, cod_question)
);