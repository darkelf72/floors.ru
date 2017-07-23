CREATE DATABASE floors;
/*
DROP TABLE room;
DROP TABLE chat;
DROP TABLE blocked;
*/
CREATE TABLE room(
    id SERIAL PRIMARY KEY,
    name varchar(50) NOT NULL UNIQUE
);

CREATE TABLE chat(
    id SERIAL PRIMARY KEY,
    message varchar(1000) NOT NULL,
    timedate timestamp NOT NULL,
/*    
    roomid int(15) NOT NULL,
    userid int(15) NOT NULL,        
*/    
    roomname varchar(50) NOT NULL,
    username varchar(50) NOT NULL  
);

CREATE TABLE blocked(
    id SERIAL PRIMARY KEY,
/*    
    blockedby varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
*/  
    username varchar(50) NOT NULL UNIQUE
);

DELETE FROM room;
DELETE FROM chat;
DELETE FROM blocked;

INSERT INTO room (name) VALUES ('room1');
INSERT INTO room (name) VALUES ('room2');
INSERT INTO room (name) VALUES ('room3');

INSERT INTO blocked (username) VALUES ('blockeduser1');
INSERT INTO blocked (username) VALUES ('blockeduser2');
INSERT INTO blocked (username) VALUES ('blockeduser3');