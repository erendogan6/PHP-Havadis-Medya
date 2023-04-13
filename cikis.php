<?php
if (!isset($_SESSION["id"])) {
    header("Location: girisEkran.php");
}
$_SESSION = array(); // destroy all $_SESSION data
setcookie("PHPSESSID", "", time() - 3600, "/");
session_destroy();
header('Location:index.html');
