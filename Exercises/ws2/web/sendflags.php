<?php
session_start();
if ($_SESSION['logged_in'] && isset($_GET['user'])){
    $link = mysqli_connect("127.0.0.1","workshop2","<password>","workshop2");

    // Don't allow sending flags to bots
    if (in_array(strtolower($_GET["user"]), array("alice", "bob", "carol", "dan"))) {
        header('Location: profile.php');
    }
    else if (strtolower($_SESSION['name']) == "dan") {
        header('Location: profile.php');
    }
    else {
        $userquery = $link->prepare("select * from users where username = ?");
        $userquery->bind_param("s", $_GET["user"]);
        $userquery->execute();
        $result = $userquery->get_result();
        if ($result->num_rows == 0) {
            // user doesn't exist
            $userquery->close();
            mysqli_close($link);
            header('Location: profile.php');
        }

        $flagquery = $link->prepare("select flag from flags where user = ?");
        $flagquery->bind_param("s", $_SESSION['name']);
        $flagquery->execute();
        $result = $flagquery->get_result();

        // Compound primary key used to avoid duplicate flags
        while($row = $result->fetch_assoc()) {
            $insertion = $link->prepare("insert into flags (flag, user) values (?,?)");
            $insertion->bind_param("ss", $row['flag'], strtolower($_GET["user"]));
            $insertion->execute();
        }
        $flagquery->close();
        mysqli_close($link);
        header('Location: profile.php');
    }
}
else {
    header('Location: index.php');
}
?>
