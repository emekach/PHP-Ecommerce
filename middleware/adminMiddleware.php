<?php

require('../functions/myfunctions.php');

if (isset($_SESSION['auth']) == true) {
    if ($_SESSION['role_as'] != 1) {

        redirect("../index.php", "you are not authorised to access this page");
    }
} else {
    echo "<script>window.location.href = '../login.php';</script>";

    exit(); // Always exit after sending a Location header

}
