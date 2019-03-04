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
    <h2>Search</h2>
    <form action="index.php" method="post">
      <label for="name">Color Search</label>
      <input type="text" id="colorsearch" name="colorsearch">
    </form>
    <h2>Ratings table</h2>
    <?php
      // I removed the filter bar because it proved confusing
      // for users. PHP code is left in for reference
      if (isset($_POST["colorfilter"])) {
          $link = mysqli_connect("127.0.0.1","ws1home","<password>","workshop1");
          $color= $_POST["colorfilter"];
          //$color= $link->real_escape_string($_POST["colorfilter"]);
          $query = "select * from colors where cname like '%" . $color . "%' order by 3 desc;";
          $result = $link->query($query);
          echo "<table>\n";
          while ($row = $result->fetch_row()) {
              echo "<tr><td>" . $row[0] . "</td><td style='background-color:#" . $row[1] . "; width:50px;'></td><td>" . $row[2] . "/10</td></tr>\n";
          }
          echo "</table>\n";
          mysqli_close($link);
      }
      else if (isset($_POST["colorsearch"])) {
          $link = mysqli_connect("127.0.0.1","ws1home","<password>","workshop1");
          $color= $_POST["colorsearch"];
          $query = "select * from colors where cname = '" . $color . "';";
          $result = $link->query($query);
          echo "<table>\n";
          while ($row = $result->fetch_row()) {
              echo "<tr><td>" . $row[0] . "</td><td style='background-color:#" . $row[1] . "; width:50px;'></td><td>" . $row[2] . "/10</td></tr>\n";
          }
          echo "</table>\n";
          mysqli_close($link);
      }
    ?>
  </div>
</body>
</html>
