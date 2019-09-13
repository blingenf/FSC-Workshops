<?php
session_start();
if (in_array(strtolower($_SESSION["name"]), array("alice", "bob", "carol", "dan"))) {
    header('Location: profile.php');
}
else if ($_SESSION['logged_in']) {
    if (!is_dir("userimages/".strtolower($_SESSION['name']))) {
        mkdir("userimages/".strtolower($_SESSION['name']), 0770, true);
    }
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "userimages/".strtolower($_SESSION['name'])."/profile.png")) {
        header('Location: profile.php');
    }
    else {
        echo 'Upload failed<br><a href="profile.php">go back</a>';
    }
}
else {
    header('Location: login.php');
}
?>
