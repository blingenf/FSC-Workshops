## Workshop 2 Solutions
### 2 - Bob
Relevant information:

- Bob sends flags to users with images > 1 MB.
- The HTML form on profile.php doesn't allow files greater than 512 kB.

Bob sends flags to any user with a profile picture larger than 1 MB. However, the HTML form for uploading files limits files to 512 kB. The easiest way to get around this is by editing HTML in Firefox or Chrome. In Firefox, this can be accomplished by opening the element inspector console.

The point of this exercise is to demonstrate that client-side controls are useless for preventing users from sending a certain input. The only way to force a size limit on a file is tot enforce it on the server side.
