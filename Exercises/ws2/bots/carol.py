import requests
import re

import time
import sys
import threading

class carolThread(threading.Thread):
    def __init__(self, ip):
        super().__init__()
        self.ip = ip
        self.name = "Carol"
        self.running = False

    def run(self):
        self.running = True

        while self.running:
            with requests.Session() as s:
                s.post(self.ip + "v0/login.php", data={"username" : "Carol", "password" : "<carol-password>"})
                users = s.get(self.ip + "v0/profile.php")

                self.sleep(60)

                users = s.get(self.ip + "v0/logout.php")

    def sleep(self, length):
        # allows near-instant interruption
        for _ in range(length):
            if self.running:
                time.sleep(1)

    def stop(self):
        self.running = False
