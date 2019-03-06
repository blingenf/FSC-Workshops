# FSC-CTF
Flag capture infrastructure designed for the FSC Lab.

## Configuration
Must be set up on a machine or virtual machine configured with:
- Webserver with PHP
- MySQL
- User accounts for every competitor
- flaguser account with disabled password
- libmysqlcppconn-dev package

Assumptions:
- Usernames are no more than 32 characters long
- Flags are no more than 20 characters long

I chose to implement the flag server in C++ rather than as a web service with PHP because it was easy to set up with our existing domain (just attach the server to the domain -> everyone already has an account!).

Everything other than flagdump.sh is placed on the flag server. Flagdump.sh is a simple bash script which connects to the flag server via ssh (the user has to enter their password, of course) and runs the flagdump command.

## Setup
### flagdump.sh (client side)
Replace <flag server ip> with the ip of the flag server.
location: /usr/local/bin/flagdump  
permissions: 755

### flagdump (server side)
build: `g++ flagdump.cpp -o flagdump`  
location: /usr/local/bin/flagdump  
permissions: 6711
owner / group: flaguser

### flagserver
Replace "[flaguser's password]" with the actual password.  
build: `g++ flagserver.cpp -o flagserver -lmysqlcppconn`  
location: /usr/local/bin/flagdump  
permissions: 700  
owner / group: flaguser

### Socket
Directory: /var/lib/flagserver  
owner / group: flaguser  
permissions: 700  

### Flag file
flag file: /var/lib/flagserver/flags  
permissions: 700  
owner: flaguser  
format:  
[flag] [flag value]  
[flag] [flag value]  
[flag] [flag value]  
etc.

Flag number is assumed to be the index of the flag in the file.

### MySQL Database
```SQL
CREATE DATABSE flagdb;
USE flagdb;
CREATE TABLE captures(time INT, user VARCHAR(32), flagn INT, value INT);
CREATE USER 'flaguser'@'localhost' IDENTIFIED BY 'a good password';
GRANT SELECT ON flagdb.captures TO 'flaguser'@'localhost';
GRANT INSERT ON flagdb.captures TO 'flaguser'@'localhost';
```

### Scoreboard
Replace "[flaguser's password]" with the actual password.  
Make sure flags.php is placed such that it is being hosted by the webserver but cannot be seen by local users.  
Example, for apache:  
Directory: /var/www/html  
permissions: 770  
group: www-data  

style.css should be in the same foler as flags.php.

## Usage
To start the server:
```
sudo su flaguser
flagserver
```
To submit a flag (from any lab machine, or from the flag server):
```
flagdump [flag]
```

Note that the code currently running in the FSC lab has been updated from the provided code to retrieve users' full names from the domain. The cpp code and SQL database were modified to add this as an extra column, and PHP code was modified to show this instead of the username. This is entirely optional.
