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
            if ($row[0] > $scoreboard[$row[1]]["lastcapture"])
                $scoreboard[$row[1]]["lastcapture"] = $row[0];
        }
        else {
            $scoreboard[$row[1]] = array(user => htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'), lastcapture => $row[0], flags => 1, points => $row[3]);
        }
    }

    array_multisort(array_column($scoreboard, 'points'), SORT_DESC,
                    array_column($scoreboard, 'lastcapture'),  SORT_ASC, $scoreboard);

    echo "<h2>Scoreboard</h2>\n";
    echo "<table>\n<tr><th></th><th>Username</th><th>Flag Captures</th><th>Score</th><th>Most Recent Capture</th>\n";
    $rank = 1;
    foreach ($scoreboard as $score) {
        $rowclass = ' class="other"';
        if ($rank == 1)
            $rowclass = ' class="first"';
        else if ($rank == 2)
            $rowclass = ' class="second"';
        else if ($rank == 3)
            $rowclass = ' class="third"';

        if ($score["flags"] == 1) {
            echo "<tr><td" . $rowclass . ">" . $rank . ". </td><td>" . $score["user"]
            . "</td><td>" . $score["flags"] . " flag</td><td>" . $score["points"]
                 . " points</td><td>" .  date('Y-m-d H:i:s', $score["lastcapture"]) . "</td></tr>\n";
        }
        else {
            echo "<tr><td" . $rowclass . ">" . $rank . ".</td><td>" . $score["user"]
            . "</td><td>" . $score["flags"] . " flags</td><td>" . $score["points"]
            . " points</td><td>" .  date('Y-m-d H:i:s', $score["lastcapture"]) . "</td></tr>\n";
        }
        $rank += 1;
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
