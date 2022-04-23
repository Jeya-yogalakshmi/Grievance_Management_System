<?php
session_start();
unset($_SESSION["uname"]);
header("Location:admin_login.php");
?>