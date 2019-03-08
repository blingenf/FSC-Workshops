from selenium import webdriver
import time
import sys
import threading

class danThread(threading.Thread):
    def __init__(self, ip):
        super().__init__()
        self.ip = ip
        self.name = "Dan"
        self.running = False

    def run(self):
        self.running = True

        profile = webdriver.FirefoxProfile()
        profile.set_preference("general.useragent.override", "bot")
        self.browser = webdriver.Firefox(profile)

        while self.running:
            self.browser.get(self.ip)
            self.sleep(4)

            # Log in
            self.browser.get(self.ip + "login.php")
            self.sleep(1)
            self.browser.find_element_by_id("username").send_keys("Dan")
            self.sleep(1)
            self.browser.find_element_by_id("password").send_keys("<dan-password>")
            self.sleep(1)
            self.browser.find_element_by_id("login").click()
            self.sleep(1)

            # View profile, enable images
            self.browser.get(self.ip + "profile.php")
            self.browser.execute_script("window.scrollTo(0,document.body.scrollHeight);")
            self.sleep(2)
            self.browser.find_element_by_id("script_en").click()
            self.sleep(2)
            self.browser.find_element_by_id("changeoptions").click()
            self.sleep(1)
            self.browser.execute_script("window.scrollTo(0,document.body.scrollHeight);")
            self.sleep(10)
            self.browser.execute_script("window.scrollTo(document.body.scrollHeight,0);")
            self.sleep(1)
            self.browser.get(self.ip + "logout.php")

        self.browser.quit()

    def sleep(self, length):
        # allows near-instant interruption
        for _ in range(length):
            if self.running:
                time.sleep(1)

    def stop(self):
        self.running = False
