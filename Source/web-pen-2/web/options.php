<?php
session_start();
if ($_SESSION['logged_in'] && isset($_POST['show_img'])){
    $_SESSION['show_img'] = True;
}
else if ($_SESSION['logged_in'] && isset($_POST['hide_img'])){
    $_SESSION['show_img'] = False;
}
if ($_SESSION['logged_in'] && isset($_POST['script_en'])){
    $_SESSION['script_en'] = True;
}
else if ($_SESSION['logged_in'] && isset($_POST['script_dis'])){
    $_SESSION['script_en'] = False;
}
header('Location: profile.php');
?>
