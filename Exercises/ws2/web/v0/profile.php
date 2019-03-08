<?php
session_start();
if ($_SESSION['logged_in']) {
    echo '<!DOCTYPE HTML>
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
    &lt;' . $_SESSION['name'] . '&gt;
    <a class="headerlink" href="profile.php">Profile</a>
    <a class="headerlink" href="logout.php">Sign Out</a>
  </div>
  <div style="clear:both;"></div>
  </div>
  <img style="width:100%;" src="../images/banner.png" alt="banner-img">
  <div class="main">
    <h2>Welcome, ' . $_SESSION['name'] . '!</h2>
    <div class="left_col">
    <img style="max-width:200px; max-height:200px;" src="/images/NCC-logo.png" alt="no user image">
    <h3>Your flags</h3>';
$link = mysqli_connect("127.0.0.1","workshop2","<password>","workshop2");

$query = $link->prepare("select flag from flags where user = ?");
$query->bind_param("s", $_SESSION['name']);
$query->execute();
$result = $query->get_result();
if ($result->num_rows == 0) {
    echo 'Looks you don\'t have any flags :(';
}
else {
    while($row = $result->fetch_assoc()) {
        echo $row['flag'] . "<br>\n";
    }
}
mysqli_close($link);

echo '</div>
      <div class="right_col">
      <h3>Recent Messages</h3>
      This version of the site is no longer secure! Please end your session as soon as possible by logging out.
      </div>
      <div style="clear:both;"></div></div>
      </body>
      </html>';
}
else {
    header('Location: login.php');
}
?>
