CREATE DATABASE bd_multimeios;
USE bd_multimeios;

CREATE TABLE tb_user (
	registron_user INTEGER PRIMARY KEY, 
	name_user VARCHAR(40) NOT NULL, 
    email_user VARCHAR(40) NOT NULL,
    password_user VARCHAR(255) NOT NULL,
	class VARCHAR(45), 
	booking_day DATE NOT NULL, 
	return_day DATE NOT NULL, 
);

CREATE TABLE tb_book (  
    id_book INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(90) NOT NULL,
    gender_book VARCHAR(45) NOT NULL,
    author_book VARCHAR (45) NOT NULL,
    picture BLOB,
    booking_day DATE NOT NULL,
    return_day DATE NOT NULL,
    registron_user INTEGER,  
    
    FOREIGN KEY (registron_user) REFERENCES tb_user(registron_user)

);

















