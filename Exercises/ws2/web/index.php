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
    <h2>Nevada Cyber Club Flag Storage website</h2>
    NCC flag storage service. Flags given to bots only!<br>
    Update from NCC FS v0: session IDs are now secure.<br>
    Make sure you are not using the old version of the site, which can be found <a href="v0">here</a>.
    <h2>Bot list</h2>
    <ul>
      <li>Alice: Enables image DMs.
      <li>Bob: Easily impressed by 1MB+ profile pictures.
      <li>Carol: still uses the old site.
      <li>Dan: Enables scripts in DMs. Somehow blocked the flag sharing functionality.
    </ul>
    <br><br><br>
  </div>
</body>
</html>
