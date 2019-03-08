import sys
import tkinter as tk
import time
from pydoc import locate

botlist = ["alice", "bob", "carol", "dan"]
for bot in botlist:
    __import__(bot)

IP = "http://172.16.4.60/ws2/"

class BotControlCenter(tk.Frame):
    def __init__(self, master=None):
        super().__init__(master)
        self.master = master
        self.pack()
        self.bots = {}
        self.bot_buttons = {}
        self.bot_labels = {}
        self.bot_status = {}

        self.initialize_interface()

    def initialize_interface(self):
        self.winfo_toplevel().title("Bot Command")

        self.bar1 = tk.Label(self)
        self.bar1["text"] = "----------------"
        self.bar1["font"] = ("Courier", 12)
        self.bar1.grid(row=0, column=0, columnspan=3)

        self.header = tk.Label(self)
        self.header["text"] = " \\!/ BOT COMMAND \\!/ "
        self.header["font"] = ("Courier", 18)
        self.header.grid(row=1, column=0, columnspan=3)

        self.bar2 = tk.Label(self)
        self.bar2["text"] = "----------------"
        self.bar2["font"] = ("Courier", 12)
        self.bar2.grid(row=2, column=0, columnspan=3)

        self.create_bot_interface()

        self.bar3 = tk.Label(self)
        self.bar3["text"] = "----------------"
        self.bar3["font"] = ("Courier", 12)
        self.bar3.grid(row=3+len(self.bot_labels), column=0, columnspan=3)

    def create_bot_interface(self):
        for i, bot in enumerate(botlist):
            self.bot_labels[bot] = tk.Label(self)
            self.bot_labels[bot]["text"] = bot + "  "
            self.bot_labels[bot]["font"] = ("Helvetica", 10)
            self.bot_labels[bot].grid(row=i + 3, column=0, sticky="E")

            self.bot_status[bot] =  label = tk.Label(self)
            self.bot_status[bot]["background"] = "Red"
            self.bot_status[bot]["text"] = " Offline "
            self.bot_status[bot]["font"] = ("Helvetica", 10)
            self.bot_status[bot].grid(row=i + 3, column=1)

            self.bot_buttons[bot] = tk.Button(self)
            self.bot_buttons[bot]["text"] = "Start"
            self.bot_buttons[bot]["font"] = ("Helvetica", 10)
            self.bot_buttons[bot]["command"] = callback=lambda bot=bot: self.toggle_bot(bot)
            self.bot_buttons[bot].grid(row=i + 3, column=2, sticky="W")

    def toggle_bot(self, bot):
        if self.bot_buttons[bot]["text"] == "Start":
            self.bots[bot] = locate(bot + "." + bot + "Thread")(IP)
            self.bots[bot].start()
            self.bot_status[bot]["background"] = "Green2"
            self.bot_status[bot]["text"] = " Online "
            self.bot_buttons[bot]["text"] = "Stop"
        else:
            self.bots[bot].stop()
            self.bots[bot].join()
            self.bot_status[bot]["background"] = "Red"
            self.bot_status[bot]["text"] = " Offline "
            self.bot_buttons[bot]["text"] = "Start"

root = tk.Tk()
app = BotControlCenter(master=root)
app.mainloop()
