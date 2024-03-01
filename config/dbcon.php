<?php

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "phpecom";

$con = mysqli_connect($hostname, $username, $password, $dbname) or die(mysqli_connect_error($con));

if (!$con) {
    die("connection Failed" . mysqli_connect_error($con));
}
mysqli_select_db($con, $dbname);
