#include <sys/socket.h>
#include <sys/un.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fstream>
#include <string>
#include <vector>
#include <ctime>
#include <iostream>

#include <mysql_driver.h>
#include <mysql_connection.h>
#include <mysql_error.h>
#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/connection.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>
#include <cppconn/prepared_statement.h>

char socket_path[] = "/var/lib/flagserver/flagsocket";

int capture_flag(std::string user, int flagn, int value);

int main(int argc, char* argv[]) {
    std::vector<std::pair<std::string,int>> flags;
    std::string filename = "/var/lib/flagserver/flags";
    std::ifstream flagfile(filename);

    std::string flag;
    int value;
    while (flagfile >> flag >> value) {
        flags.push_back(std::make_pair(flag, value));
    }

    struct sockaddr_un svr_addr, cli_addr;
    socklen_t cli_len;
    char buf[55]{0};
    char* flag_buf;
    char* usr_buf;
    int fd, new_fd, n,  svr_len;

    if( (fd = socket(AF_UNIX, SOCK_STREAM, 0)) == -1) {
        perror("Socket error");
        exit(-1);
    }

    memset(&svr_addr, 0, sizeof(svr_addr));
    svr_addr.sun_family = AF_UNIX;
    strncpy(svr_addr.sun_path, socket_path, sizeof(svr_addr.sun_path) - 1);
    svr_len = strlen(svr_addr.sun_path) + sizeof(svr_addr.sun_family);

    unlink(socket_path);
    if (bind(fd, (struct sockaddr*)&svr_addr, svr_len) == -1) {
        perror("Bind error");
        exit(-1);
    }

    if (listen(fd, 5) == -1) {
        perror("Listen error");
        exit(-1);
    }

    cli_len = sizeof(cli_addr);
    while (true){
        new_fd = accept(fd, (struct sockaddr*)&cli_addr, &cli_len);
        if (new_fd == -1) {
            perror("Accept error");
            exit(-1);
        }

        n = read(new_fd, buf, 54);
        flag_buf = strtok(buf, " ");
        usr_buf = strtok(NULL, " ");

        bool capture = false;
        for (int i=0; i < flags.size(); i++) {
            if (!strcmp(flags[i].first.c_str(), flag_buf)) {
                std::string userstring(usr_buf);

                capture = true;
                int capture_value = capture_flag(userstring, i, flags[i].second);
                if (capture_value == 1)
                    write(new_fd, "Flag Captured!\n", strlen("Flag Captured!\n"));
                else if (capture_value == 0)
                    write(new_fd, "Flag already captured\n", strlen("Flag already captured\n"));
                else
                    write(new_fd, "Database error\n", strlen("Database error\n"));
            }
        }
        if (!capture)
            write(new_fd, "Invalid flag\n", strlen("Invalid flag\n"));
        close(new_fd);
        memset(&buf, 0, sizeof(buf));
    }
    close(fd);

    return 0;
}

int capture_flag(std::string user, int flagn, int value) {
  std::string url = "127.0.0.1";
  std::string dbuser = "flaguser";
  std::string dbpass = "[flaguser's password]";
  std::string database = "flagdb";

    try {
        sql::Driver* driver = get_driver_instance();

        std::unique_ptr<sql::Connection> con(driver->connect(url, dbuser, dbpass));
        con->setSchema(database);
        std::unique_ptr<sql::Statement> stmt(con->createStatement());
        std::unique_ptr<sql::ResultSet> res;
        res.reset(stmt->executeQuery("SELECT user, flagn FROM captures"));

        bool prev_capture = false;
        while (res->next()) {
            if (res->getString("user") == user && res->getInt("flagn") == flagn) {
                prev_capture = true;
            }
        }
        if (prev_capture)
            return 0;
        else {
            std::unique_ptr<sql::PreparedStatement> pstmt(con->prepareStatement(
                 "INSERT INTO captures(time, user, flagn, value) VALUES(?,?,?,?)"));
            pstmt->setInt(1, std::time(0));
            pstmt->setString(2, user);
            pstmt->setInt(3, flagn);
            pstmt->setInt(4, value);
            pstmt->execute();
        }

  } catch (sql::SQLException &e) {
    /*
      MySQL Connector/C++ throws three different exceptions:

      - sql::MethodNotImplementedException (derived from sql::SQLException)
      - sql::InvalidArgumentException (derived from sql::SQLException)
      - sql::SQLException (derived from std::runtime_error)
    */
    std::cout << "# ERR: SQLException in " << __FILE__;
    std::cout << "(" << __FUNCTION__ << ") on line " << __LINE__ << "\n";
    /* what() (derived from std::runtime_error) fetches error message */
    std::cout << "# ERR: " << e.what();
    std::cout << " (MySQL error code: " << e.getErrorCode();
    std::cout << ", SQLState: " << e.getSQLState() << " )" <<  "\n";

    return(-1);
  }

  return 1;
}
