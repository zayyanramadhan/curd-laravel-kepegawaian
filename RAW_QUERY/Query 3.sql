-- public.education definition

-- Drop table

-- DROP TABLE public.education;

CREATE TABLE public.education (
	id bigserial NOT NULL,
	employee_id int4 NOT NULL,
	"name" varchar(255) NOT NULL,
	"level" varchar(255) NOT NULL,
	is_married bool NOT NULL,
	description varchar(255) NOT NULL,
	created_by varchar(255) NOT NULL,
	updated_by varchar(255) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT education_pkey PRIMARY KEY (id),
	CONSTRAINT education_employee_fk FOREIGN KEY (employee_id) REFERENCES public.employee(id)
);

-- public.employee definition

-- Drop table

-- DROP TABLE public.employee;

CREATE TABLE public.employee (
	id bigserial NOT NULL,
	nik varchar(255) NULL,
	"name" varchar(255) NULL,
	is_active bool NOT NULL,
	start_date date NOT NULL,
	end_date date NOT NULL,
	created_by varchar(255) NULL,
	updated_by varchar(255) NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT employee_pkey PRIMARY KEY (id)
);

-- public.employee_family definition

-- Drop table

-- DROP TABLE public.employee_family;

CREATE TABLE public.employee_family (
	id bigserial NOT NULL,
	employee_id int8 NOT NULL,
	"name" varchar(255) NULL,
	identifer varchar(255) NULL,
	job varchar(255) NULL,
	place_of_birth varchar(255) NULL,
	date_of_birth date NULL,
	religion varchar(255) NOT NULL,
	is_life bool NOT NULL,
	is_divorced bool NOT NULL,
	relation_status varchar(255) NOT NULL,
	created_by varchar(255) NULL,
	updated_by varchar(255) NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT employee_family_pkey PRIMARY KEY (id),
	CONSTRAINT employee_family_employee_fk FOREIGN KEY (employee_id) REFERENCES public.employee(id)
);

-- public.employee_profile definition

-- Drop table

-- DROP TABLE public.employee_profile;

CREATE TABLE public.employee_profile (
	id bigserial NOT NULL,
	employee_id int4 NOT NULL,
	place_of_birth varchar(255) NULL,
	date_of_birth date NULL,
	gender varchar(255) NOT NULL,
	is_married bool NOT NULL,
	prof_pict varchar(255) NULL,
	created_by varchar(255) NULL,
	updated_by varchar(255) NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT employee_profile_pkey PRIMARY KEY (id),
	CONSTRAINT employee_profile_employee_fk FOREIGN KEY (employee_id) REFERENCES public.employee(id)
);
