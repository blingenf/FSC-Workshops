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
    <h2>User list</h2>
    <?php
    $link = mysqli_connect("127.0.0.1","workshop2","<password>","workshop2");

    $query = "select username from users;";
    $result = $link->query($query);

    $leftusers = array();
    $rightusers = array();
    $odd = 0;
    while ($row = $result->fetch_row()) {
        $usrhtml = '<li>' . $row[0] . '<br><img style="max-width:100px; max-height:100px;" src="userimages/'
                   . strtolower($row[0]) . '/profile.png" alt="no user image">' . "\n";
        if ($odd == 0)
            $leftusers[] = $usrhtml;
        else
            $rightusers[] = $usrhtml;
        $odd = ($odd + 1) % 2;
    }
    mysqli_close($link);

    echo '<div class="left_col">' . "\n<ul>\n";
    foreach ($leftusers as $user)
        echo $user;
    echo '</ul>'."\n".'</div><div class="right_col">'."\n".'<ul>'."\n";
    foreach ($rightusers as $user)
        echo $user;
    ?>
    </ul>
    </div>
    <div style="clear:both;"></div>
    <br><br><br>
  </div>
</body>
</html>
