-- Create the database
DROP DATABASE IF EXISTS BankOfSPARSA;
CREATE DATABASE BankOfSPARSA;
USE BankOfSPARSA;

CREATE TABLE login (userID int primary key AUTO_INCREMENT,
  name varchar(255) not null,
  username varchar(255) not null,
  password varchar(255) not null,
  role varchar(255) default "user",
  emailAddr varchar(255));
ALTER TABLE login ADD UNIQUE (username);

-- Account Values Table
CREATE TABLE accounts (userID int AUTO_INCREMENT,
  accountNum bigint(10) unsigned,
  accountPIN int(4),
  balance float(20,2) default 0.0,
  primary key (userID));
ALTER TABLE accounts ADD UNIQUE (accountNum);

-- Create admin user
INSERT INTO login (userID,name,username,password,role,emailAddr) values(
  '0',
  'Administrator',
  'admin',
  'Changeme14',
  'admin',
  'admin@localhost');

-- Create Admin Account
INSERT INTO accounts (userID,accountNum,accountPIN) values (
  '0',
  FLOOR(RAND() * (9999999999 - 1000000000 + 1)) + 1000000000,
  FLOOR(RAND() * (999999 - 000000 + 1)) + 000000);
