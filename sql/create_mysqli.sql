CREATE DATABASE IF NOT EXISTS floors;

USE floors;

DROP TABLE IF EXISTS room;
DROP TABLE IF EXISTS chat;
DROP TABLE IF EXISTS blocked;

CREATE TABLE IF NOT EXISTS room(
    id int(15) NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL UNIQUE,
    PRIMARY KEY(id)
) DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS chat(
    id int(15) NOT NULL AUTO_INCREMENT,
    message varchar(1000) NOT NULL,
    timedate datetime NOT NULL,
/*    
    roomid int(15) NOT NULL,
    userid int(15) NOT NULL,        
*/    
    roomname varchar(50) NOT NULL,
    username varchar(50) NOT NULL,    
    PRIMARY KEY(id)
) DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS blocked(
    id int(15) NOT NULL AUTO_INCREMENT,
/*    
    blockedby varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
*/  
    username varchar(50) NOT NULL UNIQUE,
    PRIMARY KEY(id)
) DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1;

DELETE FROM room;
DELETE FROM chat;
DELETE FROM blocked;

INSERT INTO room (id,name) VALUES (NULL,'room1');
INSERT INTO room (id,name) VALUES (NULL,'room2');
INSERT INTO room (id,name) VALUES (NULL,'room3');

INSERT INTO blocked (id,username) VALUES (NULL,'blockeduser1');
INSERT INTO blocked (id,username) VALUES (NULL,'blockeduser2');
INSERT INTO blocked (id,username) VALUES (NULL,'blockeduser3');