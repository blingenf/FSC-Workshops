CREATE DATABASE workshop2;
USE workshop2;
CREATE TABLE flags(flag VARCHAR(16), user VARCHAR(32));
CREATE TABLE users(username VARCHAR(32), password VARCHAR(40));
CREATE TABLE v0users(username VARCHAR(32), password VARCHAR(40));
CREATE USER 'workshop2'@'localhost' IDENTIFIED BY '<password>';
GRANT SELECT ON workshop2.* TO 'workshop2'@'localhost';
GRANT INSERT ON workshop2.* TO 'workshop2'@'localhost';
INSERT INTO users VALUES("alice", "<alice-password>");
INSERT INTO v0users VALUES("alice", "<alice-password>");
INSERT INTO users VALUES("bob", "<bob-password>");
INSERT INTO v0users VALUES("bob", "<bob-password>");
INSERT INTO users VALUES("carol", "<carol-password>");
INSERT INTO v0users VALUES("carol", "<carol-password>");
INSERT INTO users VALUES("dan", "<dan-password>");
INSERT INTO v0users VALUES("dan", "<dan-password>");
INSERT INTO flags VALUES("46BKMaC8qhalPtdn", "alice");
INSERT INTO flags VALUES("3FyrqBoD6nOKHUJu", "bob");
INSERT INTO flags VALUES("2BufddG6EVk3zZWU", "carol");
INSERT INTO flags VALUES("79dTVDhWaK0he4b2", "dan");
