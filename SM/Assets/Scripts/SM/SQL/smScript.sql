DROP DATABASE IF EXISTS smDB;

CREATE DATABASE smDB;

USE smDB;

DROP TABLE IF EXISTS users;

CREATE TABLE users(
	username VARCHAR(100) NOT NULL,
	password VARCHAR(100) NOT NULL,
	PRIMARY KEY(username)
)ENGINE = InnoDB DEFAULT CHARACTER SET = latin1;

DROP TABLE IF EXISTS device;

CREATE TABLE device(
	address VARCHAR(500) NOT NULL,
	name VARCHAR(200) NOT NULL,
	deviceType VARCHAR(200) NOT NULL,
	PRIMARY kEY(address)
)ENGINE = InnoDB DEFAULT CHARACTER SET = latin1;

DROP TABLE IF EXISTS message;

CREATE TABLE message(
	sendtimestamp BIGINT NOT NULL,
	senderAddress VARCHAR(500) NOT NULL,
	receiverAddress VARCHAR(500) NOT NULL,
	dataContent TEXT NOT NULL,
	PRIMARY KEY(sendtimestamp, senderAddress, receiverAddress),
	FOREIGN KEY(senderAddress) REFERENCES device(address) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(receiverAddress) REFERENCES device(address) ON DELETE CASCADE ON UPDATE CASCADE	
)ENGINE = InnoDB DEFAULT CHARACTER SET = latin1;

DROP TABLE IF EXISTS expressmessage;

CREATE TABLE expressmessage(
	sendDate VARCHAR(10) NOT NULL,
	sendTime VARCHAR(8) NOT NULL,
	senderAddress VARCHAR(500) NOT NULL,
	receiverAddress VARCHAR(500) NOT NULL,
	dataContent TEXT NOT NULL,
	PRIMARY KEY(sendDate, sendTime, senderAddress, receiverAddress)	
)ENGINE = InnoDB DEFAULT CHARACTER SET = latin1;

DROP TABLE IF EXISTS deviceGroup;

CREATE TABLE deviceGroup(
	masterAddress VARCHAR(500) NOT NULL,
	deviceAddress VARCHAR(500) NOT NULL,
	PRIMARY KEY(masterAddress, deviceAddress),
	FOREIGN KEY(masterAddress) REFERENCES device(address) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(deviceAddress) REFERENCES device(address) ON DELETE CASCADE ON UPDATE CASCADE	
)ENGINE = InnoDB DEFAULT CHARACTER SET = latin1;