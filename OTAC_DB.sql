CREATE DATABASE db_otac;
USE db_otac;

CREATE TABLE tbl_Daten(
    zeit int,
    neigung int,
    beschleunigung int,
    geschwindigkeit int,
    PRIMARY KEY (Zeit) 
);

CREATE TABLE tbl_User(
    email varchar(100),
    passwd varchar(36),
    Uname varchar(30),
    PRIMARY KEY (email)
);