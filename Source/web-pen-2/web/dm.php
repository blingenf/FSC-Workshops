<?php
/*
    IMPORTANT:
    This page assumes that users can only be created
    through the register page, which forces all usernames
    to be alphanumeric. Otherwise, directory traversal is
    possible through a malicious $_POST['user'] value
*/
session_start();
if ($_SESSION['logged_in'] && isset($_POST['user']) && isset($_POST['message'])){
    $message = htmlspecialchars($_POST['message']);
    if (isset($_POST['image']))
        $message = '<img style="max-width:50px; max-height:50px;" src="' . $message . '">';

    // check if user exists
    $link = mysqli_connect("127.0.0.1","workshop2","<password>","workshop2");

    $userquery = $link->prepare("select * from users where username = ?");
    $userquery->bind_param("s", $_POST["user"]);
    $userquery->execute();
    $result = $userquery->get_result();
    if ($result->num_rows == 0) {
        echo 'Error: user doesn\'t exist<br>
              <a href="profile.php">go back</a>';
    }
    else {
        if (!is_dir("/var/www/messages/" . strtolower($_POST['user']))) {
            mkdir("/var/www/messages/" . strtolower($_POST['user']), 0770, true);
        }
        $path = "/var/www/messages/" . strtolower($_POST['user']) . '/' . strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $_SESSION['name']));
        file_put_contents($path, $message, LOCK_EX);
        echo 'Message sent!<br>
              <a href="profile.php">go back</a>';
    }
    $userquery->close();
    mysqli_close($link);
}
else if ($_SESSION['logged_in'] && isset($_POST['delete'])) {
    if (!is_dir("/var/www/messages/" . strtolower($_SESSION['name']))) {
        mkdir("/var/www/messages/" . strtolower($_SESSION['name']), 0770, true);
    }
    $files = glob("/var/www/messages/" . strtolower($_SESSION['name']) . '/*');
    foreach ($files as $file) {
        if (is_file($file))
            unlink($file);
    }
    header('Location: profile.php');
}
else {
    header('Location: index.php');
}
?>
