#include <sys/socket.h>
#include <sys/un.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

char socket_path[] = "/var/lib/flagserver/flagsocket";

int main(int argc, char* argv[]) {
    if (argc == 1) {
        printf("Usage: submitflag <flag>\n");
        exit(0);
    }

    struct sockaddr_un svr_addr;
    char flag_buf[51];
    char usr_buf[51];
    char send_buf[101] {0};
    int fd, svr_len, n;

    if( (fd = socket(AF_UNIX, SOCK_STREAM, 0)) == -1) {
        perror("Socket error");
        exit(-1);
    }

    memset(&svr_addr, 0, sizeof(svr_addr));
    svr_addr.sun_family = AF_UNIX;
    strncpy(svr_addr.sun_path, socket_path, sizeof(svr_addr.sun_path) - 1);
    svr_len = strlen(svr_addr.sun_path) + sizeof(svr_addr.sun_family);

    if (connect(fd, (struct sockaddr*)&svr_addr, svr_len) == -1) {
        perror("Connect error");
        exit(-1);
    }

    getlogin_r(usr_buf, 50);
    strncpy(flag_buf, argv[1], sizeof(flag_buf) - 1);

    for (int i = 0; i++; i < 50) {
        if (flag_buf[i] == '\xff')
            flag_buf[i] = '_';
        if (usr_buf[i] == '\xff')
            usr_buf[i] = '_';
    }

    strncpy(send_buf, usr_buf, sizeof(usr_buf) - 1);
    strncat(send_buf, "\xff", 1);
    strncat(send_buf, flag_buf, sizeof(flag_buf) - 1);
    strncat(send_buf, "\xff", 1);

    write(fd, send_buf, strlen(send_buf));
    memset(&send_buf, 0, sizeof(send_buf));
    n = read(fd, send_buf, 100);
    printf("%s", send_buf);
    close(fd);

    return 0;
}