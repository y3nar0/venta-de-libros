drop database if exists appweb_proyecto;

create database appweb_proyecto;

use appweb_proyecto;

create table usuarios(
id smallint not null auto_increment,
rol smallint not null default 2,
matricula varchar(20) not null,
nombre varchar(100) not null,
correo varchar(100) not null,
telefono varchar(20),
carrera varchar(3) not null,
password varchar(32) not null,
imagen varchar(20) not null default "default.svg",
constraint pk_usuarios_id primary key (id),
constraint uk_usuarios_matricula unique (matricula)
);

create table libros(
id smallint not null auto_increment,
tipo varchar(11) not null,
nombre varchar(100) not null,
descripcion varchar(200) not null,
estado varchar(12) not null,
costo int not null,
imagen varchar(24) not null,
vendido boolean not null default 0,
baja boolean not null default 0,
propietario smallint not null,
constraint pk_libros_id primary key (id),
constraint fk_libros_propietario_usuarios_id foreign key (propietario) references usuarios (id) on delete restrict on update restrict
);

create table compras(
id smallint not null auto_increment,
matricula varchar(20) not null,
carrera varchar(3) not null,
telefono varchar(20) not null,
correo varchar(100) not null,
lugar varchar(100) not null,
id_libro smallint not null,
constraint pk_compras_id primary key (id),
constraint fk_compras_id_libro_libros_id foreign key (id_libro) references libros (id) on delete restrict on update restrict
);
