import requests
import re

import time
import sys
import threading

class bobThread(threading.Thread):
    def __init__(self, ip):
        super().__init__()
        self.ip = ip
        self.name = "Bob"
        self.running = False

    def run(self):
        self.running = True

        while self.running:
            with requests.Session() as s:
                s.post(self.ip + "login.php", data={"username" : "Bob", "password" : "<bob-password>"})
                users = s.get(self.ip + "userimages")
                links = [link[9:-2] + "profile.png"
                         for link in re.findall('<a href="[a-zA-Z0-9]+?/">', users.text)]

                for link in links:
                    if int(s.head(self.ip + "userimages/" + link).headers['content-length']) >= 1048576:
                        s.get(self.ip + "sendflags.php?user=" + link[:-12])

            self.sleep(10)

    def sleep(self, length):
        # allows near-instant interruption
        for _ in range(length):
            if self.running:
                time.sleep(1)

    def stop(self):
        self.running = False
