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
  <img style="width:100%;" src="../images/banner.png" alt="banner-img">
  <div class="main">
    <h2>Notice</h2>
    Due to security issues, creating users on NCC FS v0 is no longer allowed.
    <br><br>
  </div>
</body>
</html>
