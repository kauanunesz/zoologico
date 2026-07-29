create database bd_zoologico;
use bd_zoologico;

create table animais(
	id int auto_increment primary key,
    nome varchar(50) not null, 
    descricao text default null,
    habitat varchar(50) not null,
    alimentacao text not null,
    idade tinyint unsigned not null,
    peso INT UNSIGNED not null,
    foto blob not null,
    data_cadastro blob
);

