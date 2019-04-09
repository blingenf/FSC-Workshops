from time import time
import random
from math import e

random.seed()

# Here I'm generating the possible users / ips
# There are 17 users and 40 ips. Both follow an exponential distribution,
# which is common in logs (though in practice they're usually a bit more
# skewed than the ones I use here)

# User list from https://github.com/danielmiessler/SecLists
users = ["root","admin","test","guest","info","adm","mysql","user",
         "administrator","oracle","ftp","pi","puppet","ansible","ec2-user",
         "vagrant","azureuser"]
user_weights = list(reversed([e**(i/10) for i in range(10,91,5)]))

ips = random.sample(["192.168.{}.{}".format((i//256) % 256, i % 255 + 1)
                     for i in range(2**16-2)], 40)
ip_weights = [e**(i/10) for i in range(10,89,2)]

# distribution for login type and if it was successful or not
# passwords and failures have much higher weights
login_types = ["password", "ssh key"]
login_weights = [99, 1]

result_types = ["Failed", "Successful"]
result_weights = [99.5, 0.5]

# start the log roughly 7 months before current time
# each new log event will be somewhere between 0 and 9.6 after the previous
# in this case I just generate the weights randomly
current_time = time() - 50000000
delta_t = [t/10 for t in range(0,100,2)]
time_weights = random.choices(range(150), k=50)

for i in range(10000):
    user = random.choices(users, weights=user_weights)[0]
    ip = random.choices(ips, weights=ip_weights)[0]
    login_type = random.choices(login_types, weights=login_weights)[0]
    result = random.choices(result_types, weights=result_weights)[0]

    # occasionally have some special events :)
    event = random.randint(2,200)
    if event > 5 and event < 197:
        # normal entry
        print("{:.0f} [logd] ".format(current_time) + result + " " +
              login_type + " for account " + user + " from " + ip)
    elif event <= 5:
        # duplicated entry
        print("{:.0f} [logd] ".format(current_time) +
              "repeated {} times: [ ".format(event) + result + " " +
              login_type + " for account " + user + " from " + ip + " ]")
    else:
        # Error
        print("{:.0f} [logd] ".format(current_time) + "Error: " +
              "Failed to do a thing")

    current_time += random.choices(delta_t, weights=time_weights)[0]
