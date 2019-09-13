<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>Flag Storage</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="header">
    <div class="topbar">
      <a class="headerlink" href="index.php"><b>NCC Flag Storage v0</b></a>
    </div>
    <div class="profilebar">
      <a class="headerlink" href="login.php">Sign In</a>
      <a class="headerlink" href="register.php">Register</a>
    </div>
    <div style="clear:both;"></div>
  </div>
  <img style="width:100%;" src="../images/banner.png" alt="banner-img">
  <div class="main">
    <?php
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $link = mysqli_connect("127.0.0.1","workshop2","<password>","workshop2");

        $query = $link->prepare("select * from v0users where username = ? and password = ?");
        $query->bind_param("ss", $_POST["username"], $_POST["password"]);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows == 0) {
            echo "<h2>login failed</h2>";
        }
        else {
            session_id(strtoupper($_POST["username"]) . "-SESSION-" . strval(random_int(100,999)));
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['name'] = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
            header("Refresh:0; url=profile.php");
        }
        $query->close();
        mysqli_close($link);
    }
    else {
        echo '<h2>User Login</h2>
        <form action="login.php" method="post">
          <label for="username">Username:</label> <input type="text" id="username" name="username"><br><br>
          <label for="password">Password:</label> <input type="password" id="password" name="password"><br><br>
          <button type="submit">Login</button>
        </form>';
    }
    ?>
  </div>
</body>
</html>
