<?php


$con=new mysqli('localhost','root','','feedback');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>

