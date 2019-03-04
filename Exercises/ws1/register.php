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
        $link = mysqli_connect("127.0.0.1","ws1register","<password>","workshop1");
        $username = $_POST["username"];
        $password = $_POST["password"];
        //$username = $link->real_escape_string($_POST["username"]);
        //$password = $link->real_escape_string($_POST["password"]);
        $query = "select * from users2 where username ='" . $username . "';";
        $result = $link->query($query);
        if (mysqli_num_rows($result) == 0) {
            echo "<h2>OK</h2>";
        }
        else {
            echo "<h2>Error: user exists</h2>";
        }
        mysqli_close($link);
    }
    else {
        echo '<h2>New User Registration</h2>
          <form action="register.php" method="post">
            <label for="username">Username:</label> <input type="username" id="username" name="username"><br><br>
            <label for="password">Password:</label> <input type="text" id="password" name="password"><br><br>
            <button type="submit">Register</button>
          </form>';
    }
    ?>
  </div>
</body>
</html>
