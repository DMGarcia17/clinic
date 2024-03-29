create database clinic;
use clinic;

create table users (
	username varchar(20) not null primary key,
	password varchar(70),
	complete_name varchar(500),
	cod_rol varchar(10),
	add_date datetime,
	user_add varchar(20),
	mod_date datetime,
	user_mod varchar(20),
	last_pass_up datetime,
	default_clinic int
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
	cellphone_number varchar(15),
	address varchar(250),
	city varchar(250),
	state varchar(250),
	postal_code varchar(10),
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
	comments varchar(1000)
);

create table answer_mq (
	cod_patient int,
	cod_question int,
	answer varchar(2),
	unique(cod_patient, cod_question)
);

create table appointment (
	cod_appointment int auto_increment primary key,
	cod_patient int not null,
	reason varchar(1500),
	visited_on datetime,
	comments varchar(4000),
	diseases_code varchar(250),
	diagnosis_resume varchar(250),
	treatment varchar(2000),
	description varchar(2000),
	disability_days int,
	constraint `fk_patients` foreign key (cod_patient) references patients(cod_patient)
);


create table medicines (
	cod_medicine int auto_increment primary key,
	chemical_compound varchar(500),
	description varchar(500),
	indication varchar(1000)
);


create table prescriptions (
	cod_prescription int primary key,
	cod_appointment int,
	constraint `fk_appointment` foreign key (cod_appointment) references appointment (cod_appointment)  on delete cascade
);

create table mpp (
	cod_mpp int auto_increment primary key,
	cod_prescription int,
	cod_medicine int,
	amount varchar(500),
	indication varchar(500),
	constraint fk_prescription foreign key (cod_prescription) references prescriptions(cod_prescription) on delete cascade,
	constraint `fk_medicine` foreign key (cod_medicine) references medicines (cod_medicine) on delete cascade
);

create table files (
	cod_file int auto_increment primary key,
	cod_patient int not null,
	cod_appointment int,
	name varchar(1000),
	constraint fk_appointment_f foreign key (cod_appointment) references appointment(cod_appointment)
);

create table events (
	cod_event int auto_increment primary key,
	name varchar(500) not null,
	start_at datetime,
	end_at datetime,
	clinic int,
	event_type varchar(10)
);


ALTER TABLE patients 
ADD is_allergic VARCHAR(2);
ALTER TABLE patients 
ADD allergies VARCHAR(500);
ALTER TABLE diseases 
ADD diseases_code VARCHAR(250);
alter table appointment 
add next_appointment DATETIME;
	
	
INSERT INTO clinic.treatments (name,pr_order,description,show_rp,paediatric_treatment) VALUES
	 ('RadiografÃ­a',1,'Las radiografÃ­as dentales son un tipo de imagen de los dientes y la boca. Los rayos X son una forma de radiaciÃ³n electromagnÃ©tica de alta energÃ­a y penetran el cuerpo para formar una imagen en una pelÃ­cula o en una pantalla.','S','S'),
	 ('Limpiezas dentales (profilaxis)',2,'PrevenciÃ³n o control de la propagaciÃ³n de una infecciÃ³n o enfermedad.','S','S'),
	 ('Obturaciones',3,'Una obturaciÃ³n dental es una restauraciÃ³n de algÃºn diente que ha sido daÃ±ado por caries.','S','S'),
	 ('PrÃ³tesis Fija',4,'Una prÃ³tesis dental consiste en un aparato fabricado a medida de la boca del paciente que sustituye una o varias piezas dentales perdidas. ','S','S'),
	 ('PrÃ³tesis removible',5,'Una prÃ³tesis removible es una prÃ³tesis que se quita y se pone; sustituye las piezas que hemos perdido en boca de una forma removible, es decir, es un aparato de quita y pon al que se le colocan los dientes que hemos perdido','S','S'),
	 ('PrÃ³tesis Total',6,'Las prÃ³tesis dentales totales o completas son dispositivos extraibles que pueden usarse para reemplazar los dientes que faltan.','S','S'),
	 ('Blanqueamiento dental',7,'El blanqueamiento dental es un tratamiento de odontologÃ­a estÃ©tica que tiene por objetivo eliminar las manchas dentales y hacer que la denticiÃ³n adquiera una tonalidad mÃ¡s blanca y brillante. La actual popularidad de la estÃ©tica ha convertido a este procedimiento odontolÃ³gico en uno de los mÃ¡s solicitados de los Ãºltimos aÃ±os.','S','S'),
	 ('Endodoncia',8,'La endodoncia es un procedimiento que tiene como finalidad preservar las piezas dentales daÃ±adas, evitando asÃ­ su pÃ©rdida. Para ello, se extrae la pulpa dental y la cavidad resultante, se rellena y sella con material inerte y biocompatible.','S','S'),
	 ('Carillas',9,'Las carillas dentales son uno de los tratamientos con mayor demanda dentro de la especialidad de OdontologÃ­a EstÃ©tica.  Y no es de extraÃ±ar, pues permite mejorar sustancialmente el aspecto de los dientes de forma muy rÃ¡pida y eficaz.  De este modo, la persona no necesita someterse a un tratamiento que requiera mÃ¡s tiempo y consigue la estÃ©tica dental que desea tener. ','S','S');

-- Create function for bulk load disease
CREATE FUNCTION obt_last_order() RETURNS int 	
BEGIN

   DECLARE last_order INT;

   SET last_order = 0;

   select ifnull(max(pr_order), 0)+1 new_order into last_order from diseases d;

   RETURN last_order;

END;

alter table appointment add
cod_clinic int;
alter table appointment 
add next_appointment DATETIME;

create or replace trigger ins_new_appointment after insert on clinic.appointment
for each row 
begin 
	if new.next_appointment is not null then 
		insert into 
			events(name, start_at, end_at, clinic, event_type) 
		values 
			((select concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) from patients p where cod_patient = new.cod_patient), new.next_appointment, addtime(new.next_appointment, '1:00'), new.cod_clinic, '1');
	end if;
end;

alter table patients
add systemic_diagnosis varchar(500);
alter table appointments
add oral int;
alter table clinics
add wssp_phone varchar(15);

/**
* Recreate of all constraints for adding cascade clause
*/

alter table files
drop foreign key fk_patient;

alter table files
drop foreign key fk_appointment_f;

alter table files
add constraint fk_appointment_f
foreign key (cod_appointment) references appointment(cod_appointment)
on delete cascade;

alter table appointment
drop foreign key fk_patients;

alter table appointment
add constraint fk_patients
foreign key (cod_patient) references patients(cod_patient)
on delete cascade;

/**
* End of recreating
*/

create table invoices (
	cod_invoice int auto_increment primary key,
	cod_appointment int not null,
	treatment varchar(250),
	amount double,
	created_at date,
	paid_at date,
	constraint fk_app_invoi foreign key (cod_appointment) references appointment (cod_appointment) on delete cascade
);

create table payments (
	cod_payment int auto_increment primary key,
	cod_invoice int not null,
	amount double,
	paid_at date,
	constraint fk_payments foreign key (cod_invoice) references invoices (cod_invoice) on delete cascade
);
-- TO APPLY
alter table mpp
drop constraint fk_medicine;

alter table mpp
modify cod_medicine VARCHAR(500);

alter table mpp
rename column cod_medicine to medicine;