<?php
session_start();
if ($_SESSION['logged_in']) {
    echo '<!DOCTYPE HTML>
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
    &lt;' . $_SESSION['name'] . '&gt;
    <a class="headerlink" href="profile.php">Profile</a>
    <a class="headerlink" href="logout.php">Sign Out</a>
  </div>
  <div style="clear:both;"></div>
  </div>
  <img style="width:100%;" src="images/banner.png" alt="banner-img">
  <div class="main">
    <h2>Welcome, ' . $_SESSION['name'] . '!</h2>
    <div class="left_col">
    <img style="max-width:200px; max-height:200px;" src="userimages/' . strtolower($_SESSION['name']) . '/profile.png" alt="no user image">
    <h3>Your flags</h3>';
if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == "bot") {
    echo 'Bots don\'t get to see their flags!';
}
else {
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
}
echo '<h3>Send flags</h3>
      Gift your flags to another user:<br><br>
      <form action="sendflags.php" method="get">
        <label for="user">User:</label> <input type="text" id="user" name="user"><br><br>
        <button type="submit">Send flags</button>
      </form>
      <h3>Options</h3>
      <div style="width:70%;">WARNING: do not enable scripts unless you know what you\'re doing!</div>
      <form action="options.php" method="post">' ."\n";
      if ($_SESSION['show_img'] == False)
          echo '<label for="show_img">Show image DMs</label> <input type="checkbox" id="show_img" name="show_img"><br>'. "\n";
      else
          echo '<label for="hide_img">Hide image DMs</label> <input type="checkbox" id="hide_img" name="hide_img"><br>'. "\n";
      if ($_SESSION['script_en'] == False)
          echo '<label for="script_en">Enable script DMs</label> <input type="checkbox" id="script_en" name="script_en"><br><br>'. "\n";
      else
          echo '<label for="script_dis">Diable script DMs</label> <input type="checkbox" id="script_dis" name="script_dis"><br><br>'. "\n";
      echo '<button id="changeoptions" type="submit">Update</button>
      </form>
      </div>
      <div class="right_col">
        <h3>Change profile picture</h3>
        (512 KB max)
        <form enctype="multipart/form-data" action="upload.php" method="POST">
          <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
          <input name="file" type="file" />
          <input type="submit" value="Upload" />
        </form>
        <h3>Send message</h3>
          Send a message or image to another user:<br><br>
          <form action="dm.php" method="post">
            <label for="user">User:</label> <input type="text" id="user" name="user"><br><br>
            <label for="message">Message:</label> <input type="text" id="message" name="message"><br><br>
            <label for="image">Image?</label> <input type="checkbox" id="image" name="image"><br><br>
            <button id="senddm" type="submit">Send message</button>
          </form>
        <h3>Recent messages</h3>' . "\n";
        $dir = '/var/www/messages/' . strtolower($_SESSION['name']) . "/";
        $messages = scandir($dir);
        foreach ($messages as $message) {
            if ($message != "." && $message != "..") {
                echo '<div class="msgbox">
                      <div class="usrbox"><img style="max-width:50px; max-height:50px;" src="userimages/' . $message . '/profile.png" alt=" "><br>';
                if ($_SESSION['script_en'] == True)
                    echo $message . '</div><div class="txtbox">' . htmlspecialchars_decode(file_get_contents($dir . $message)) . "<br>\n";
                else if ($_SESSION['show_img'] == True)
                    echo $message . '</div><div class="txtbox">' . file_get_contents($dir . $message) . "<br>\n";
                else
                    echo $message . '</div><div class="txtbox">' . htmlspecialchars(file_get_contents($dir . $message)) . "<br>\n";
                echo "</div></div>\n";
            }
        }
      echo '<br><form action="dm.php" method="post">
        <button name="delete" value="true">Delete all messages</button>
      </form></div>
      <div style="clear:both;"></div>
    </div>
  </body>
  </html>';
}
else {
    header('Location: login.php');
}
?>
