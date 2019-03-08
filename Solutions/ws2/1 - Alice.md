## Workshop 2 Solutions
### 1 - Alice
Relevant information:

- Alice enables images on her profile.
- sendflags.php uses a GET request.
- HTML special characters are escaped in a normal message, but an image message provides syntax for displaying an image.
- When an image is loaded in an HTML page, the web browser automatically makes a GET request to the url of the image.

Alice's flag can be obtained through a Cross-site Request Forgery (CSRF) attack. A CSRF attack is when an attacker tricks a user into taking an action, taking advantage of the fact the user is logged in. In this case, the goal is to trick Alice into clicking on sendflags.php?user=&lt;your user&gt;. Because the browser makes a GET request to load images, this can be accomplished simply by sending the sendflags link to Alice and marking it as an image.

This point of this exercise is to demonstrate why GET requests should never have side effects. Any request that changes something on the server should be done using POST. If sendflags.php used a POST request, this attack would not be possible.
