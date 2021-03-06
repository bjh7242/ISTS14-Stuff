-- Create the database
DROP DATABASE IF EXISTS BankOfSPARSA;
CREATE DATABASE BankOfSPARSA;
USE BankOfSPARSA;

CREATE TABLE login (userID int primary key AUTO_INCREMENT,
  name varchar(255) not null,
  username varchar(255) not null,
  password varchar(255) not null,
  role varchar(255) default "user",
  emailAddr varchar(255),
  last_login DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);
ALTER TABLE login ADD UNIQUE (username);
ALTER TABLE login ADD UNIQUE (emailAddr);

-- Account Values Table
CREATE TABLE accounts (userID int AUTO_INCREMENT,
  accountNum varchar(10),
  accountPIN varchar(4),
  balance numeric(16,2) default 0.0,
  primary key (userID));
ALTER TABLE accounts ADD UNIQUE (accountNum);

-- Create Transactions Table
CREATE TABLE transactions ( transactionID INT NOT NULL AUTO_INCREMENT,
  src_routing_num varchar(2) NOT NULL,
  src_acct BIGINT UNSIGNED NOT NULL,
  dst_routing_num varchar(2) NOT NULL,
  dst_acct BIGINT UNSIGNED NOT NULL,
  amount numeric(16,2) NULL DEFAULT NULL,
  timestamp DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (transactionID));

INSERT INTO login (userID, name, username, password, role, emailAddr) VALUES (
	0, 
	'Administrator', 
	'admin', 
	'7aabb55058c67df84864d53d82e9e8a169b252ac', 
	'admin', 
	'admin@localhost');

-- Create Admin Account
INSERT INTO accounts (userID,accountNum,accountPIN) values (
  '0',
  FLOOR(RAND() * (9999999999 - 1000000000 + 1)) + 1000000000,
  FLOOR(RAND() * (9999 - 1000 + 1)) + 1000);
