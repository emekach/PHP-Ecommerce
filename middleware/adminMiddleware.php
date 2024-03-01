<?php

if (isset($_SESSION['auth'])) {
    if ($_SESSION['role_as'] != 1) {

        $_SESSION['message'] = "you are not authorised to access this page";
        header('Location: ../index.php');
        die();
    }
} else {
    $_SESSION['message'] = "Login to continue";
    header('Location: ../login.php');
    die();
}
