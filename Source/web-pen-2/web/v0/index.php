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
    <h2>Nevada Cyber Club Flag Storage website</h2>
    WARNING: this is an insecure version of the flag storage site kept for legacy purposes. There are serious session management issues in this site. Please use Flag Storage v1!<br>
    It turns out the session cookie "&lt;USERNAME&gt;-SESSION-###" isn't actually secure! Sorry.
    <h2>Problem users</h2>
    <ul>
      <li>Alice: cicks on every link anyone sends her.
      <li>Bob: sends flags to users with 1MB+ profile pictures.
      <li>Carol: last scan showed she has a weak password.
      <li>Dan: always opens png files people send him.
    </ul>
    <br><br><br>
  </div>
</body>
</html>
