<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>Color Rank</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <h1>All the colors, ranked</h1>
    <div class="topbar">
      <a class="headerlink" href="index.php">Home</a>
      <a class="headerlink" href="register.php">Register</a>
      <a class="headerlink" href="login.php">Sign In (User)</a>
      <a class="headerlink" href="login-admin.php">Sign In (Admin)</a>
    </div>
    <div style="clear:both;"></div>
  </div>
  <div class="main">
    <?php
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $password1 = "<password1>";
        $password2 = "<password2>";
        if ($_POST["username"] == "administrator") {
            $charcount = strlen($password1);
            $failed = False;
            for ($i=0; $i<$charcount; $i++) {
                usleep(50000);
                if ($password1[$i] != $_POST["password"][$i]) {
                    $failed = True;
                    break;
                }
            }
            if ($failed == True) {
                echo "<h2>Login failed</h2>";
            }
            else {
                usleep(50000);
                echo "<h2>Admin Panel</h2>\nWelcome, administrator. The flag is <flag1>.<br><br>\n";
                echo "<h4>Updates</h4>\nPicked a new username from that cirt-default-usernames.txt file I found on the internet.<br><br>\n";
            }
        }
        else if ($_POST["username"] == "WebAdmin") {
            $charcount = strlen($password2);
            $failed = False;
            for ($i=0; $i<$charcount; $i++) {
                usleep(50000);
                if ($password2[$i] != $_POST["password"][$i]) {
                    $failed = True;
                    break;
                }
            }
            if ($failed == True) {
                echo "<h2>Login failed</h2>";
            }
            else {
                usleep(50000);
                echo "<h2>Admin Panel</h2>\nWelcome, Web-Admin. The flag is <flag2>.<br><br>\n";
            }
        }
        else {
            echo "<h2>Login failed</h2>";
        }
    }
    else {
        echo '<h2>Admin login</h2>
          Notice: the admin password has been spread about the machine and is checked one character at a time to stop those pesky hackers from sneaking it out of the server.<br><br>
          <form action="login-admin.php" method="post">
            <label for="username">Username:</label> <input type="username" id="username" name="username"><br><br>
            <label for="password">Password:</label> <input type="text" id="password" name="password"><br><br>
            <button type="submit">Login</button>
          </form>';
    }
    ?>
  </div>
</body>
</html>
