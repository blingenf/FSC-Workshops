<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>Flag Storage</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="topbar">
      <a class="headerlink" href="index.php"><b>NCC Flag Storage v1</b></a>
      <a class="headerlink" href="users.php">Users</a>
    </div>
    <div class="profilebar">
      <?php
          session_start();
          if ($_SESSION['logged_in']) {
              echo '&lt;' . $_SESSION['name'] . '&gt;
                    <a class="headerlink" href="profile.php">Profile</a>
                    <a class="headerlink" href="logout.php">Sign Out</a>';
          }
          else
              echo '<a class="headerlink" href="login.php">Sign In</a>
                    <a class="headerlink" href="register.php">Register</a>';
      ?>
    </div>
    <div style="clear:both;"></div>
  </div>
  <img style="width:100%;" src="images/banner.png" alt="banner-img">
  <div class="main">
    <br><br>
    <h2>Notice</h2>
    This is an intentionally vulnerable service. Please do not use your actual password!<br><br>
    Note that only alphanumeric characters are allowed in the username.
    <?php
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $link = mysqli_connect("127.0.0.1","workshop2","<password>","workshop2");
        $username = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST["username"]);

        $query = $link->prepare("select * from users where username = ?");
        $query->bind_param("s", $_POST["username"]);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows != 0) {
            echo "<h2>Error: user already exists</h2>";
        }
        else {
            $insertion = $link->prepare("insert into users (username, password) values (?,?)");
            $insertion->bind_param("ss", $username, $_POST["password"]);
            $insertion->execute();

            if ($insertion->affected_rows == 1) {
                echo "<h2>User " . $username ." successfully created</h2>";
            }
            else {
                echo "<h2>Error creating user</h2>";
            }
            $insertion->close();
        }
        $query->close();
        mysqli_close($link);
    }
    else {
        echo '<h2>User Registration</h2>
        <form action="register.php" method="post">
          <label for="username">Username:</label> <input type="text" id="username" name="username"><br><br>
          <label for="password">Password:</label> <input type="password" id="password" name="password"><br><br>
          <button type="submit">Login</button>
        </form>';
    }
    ?>
  </div>
</body>
</html>
