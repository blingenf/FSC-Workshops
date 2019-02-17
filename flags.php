<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>Flags</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <h1>Flag Captures</h1>
    <div style="clear:both;"></div>
  </div>
  <div class="main">
    <?php
    date_default_timezone_set('America/Los_Angeles');
    $link = mysqli_connect("127.0.0.1","flaguser","[flaguser's password]","flagdb");
    $query = "select * from captures;";
    $result = $link->query($query);

    $capturelog = array();

    $scoreboard = array();
    while ($row = mysqli_fetch_array($result)) {
        $capturelog[] = date('Y-m-d H:i:s', $row[0])  . " : " . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') .
                         " : Flag " . $row[2] . ", " . $row[3] . " points.<br>\n";

        if (array_key_exists($row[1], $scoreboard)) {
            $scoreboard[$row[1]]["flags"] += 1;
            $scoreboard[$row[1]]["points"] += $row[3];
        }
        else {
            $scoreboard[$row[1]] = array(user => htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'), flags => 1, points => $row[3]);
        }
    }

    usort($scoreboard, function($a, $b) { return $b["points"] <=> $a["points"]; });

    echo "<h2>Scoreboard</h2>\n";
    echo "<table>\n";
    foreach ($scoreboard as $index=>$score) {
        if ($score["flags"] == 1) {
            echo "<tr><td>" . ($index + 1) . ". </td><td>" . $score["user"] . "</td><td>" . $score["flags"] . " flag</td><td>" . $score["points"] . " points</td></tr>\n";
        }
        else {
            echo "<tr><td>" . ($index + 1) . ".</td><td>" . $score["user"] . "</td><td>" . $score["flags"] . " flags</td><td>" . $score["points"] . " points</td></tr>\n";
        }
    }
    echo "</table>\n";

    echo "<h2>Capture Log</h2>\n<p>\n";
    foreach ($capturelog as $capture) {
        echo $capture;
    }
    echo "</p>\n";

    mysqli_close($link);
    ?>
  </div>
</body>
</html>
