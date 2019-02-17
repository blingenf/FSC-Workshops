# FSC-CTF
CTF Infrastructure designed for the FSC Lab.  
May or may not be secure.

## Host Configuration
Must be set up on a machine or virtual machine configured with:
- Webserver with PHP
- MySQL
- User accounts for every competitor
- flaguser account with disabled password
- libmysqlcppconn-dev package

Assumptions:
- Usernames are no more than 32 characters long
- Flags are no more than 20 characters long

## Setup
### flagdump
build: `g++ flagdump.cpp -o flagdump`  
location: /usr/bin/flagdump  
permissions: 6711
owner / group: flaguser

### flagserver
Replace "[flaguser's password]" with the actual password.  
build: `g++ flagserver.cpp -o flagserver -lmysqlcppconn`  
location: /usr/bin/flagdump  
permissions: 700  
owner / group: flaguser

### Socket
Directory: /var/run/flagserver  
owner / group: flaguser  
permissions: 700  

### Flag file
flag file: /var/lib/flagserver/flags  
permissions: 700  
format:  
[flag] [flag value]  
[flag] [flag value]  
[flag] [flag value]  
etc.

Flag number is assumed to be the index of the flag in the file.

### MySQL Database
```
CREATE DATABSE flagdb;
USE flagdb;
CREATE TABLE captures(time INT, user VARCHAR(32), flagn INT, value INT);
CREATE USER 'flaguser'@'localhost' IDENTIFIED BY 'a good password';
GRANT SELECT ON flagdb.captures TO ‘flaguser’@'localhost’;
GRANT INSERT ON flagdb.captures TO ‘flaguser’@'localhost’;
```

### Scoreboard
Make sure flags.php is placed such that it is being hosted by the webserver.  
Replace "[flaguser's password]" with the actual password.  

## Usage
To start server:
```
sudo su flaguser
flagserver
```
To submit flag:
```
flagdump [flag]
```
