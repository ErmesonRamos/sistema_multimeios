CREATE DATABASE bd_multimeios;
USE bd_multimeios;
CREATE TABLE tb_book (
    id_book INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(90) NOT NULL,
    gender_book VARCHAR(45) NOT NULL,
    picture BLOB,
    booking_day DATE NOT NULL,
    return_day DATE NOT NULL,
    registron_student INTEGER,
    registron_teacher INTEGER,
    FOREIGN KEY (registron_student) REFERENCES tb_student(registron_student),
    FOREIGN KEY (registron_teacher) REFERENCES tb_teacher(registron_teacher)
);
CREATE TABLE tb_student(registron_student INTEGER PRIMARY KEY, name_student VARCHAR(40) NOT NULL, class VARCHAR(45), booking_day DATE NOT NULL, 
return_day DATE NOT NULL, picture BLOB);
CREATE TABLE tb_teacher(registron_teacher INTEGER PRIMARY KEY, name_teacher VARCHAR(45) NOT NULL, booking_day DATE, return_day DATE, picture BLOB);
CREATE TABLE tb_admin(id_admin INTEGER PRIMARY KEY, email_admin VARCHAR(45) NOT NULL, password_adim VARCHAR(45) NOT NULL);
DROP TABLE tb_book;
DROP TABLE tb_student;
DROP TABLE tb_teacher;
SELECT * FROM tb_book;
SELECT * FROM tb_student;
SELECT * FROM tb_teacher;
SELECT * FROM tb_admin;