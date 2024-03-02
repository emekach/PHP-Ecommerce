<?php

include('../functions/myfunctions.php');

$admin_user = $_SESSION['auth_user']['email'];
$admin_role = $_SESSION['role_as'];


if (isset($_SESSION['auth']) && isset($admin_user) && isset($admin_role)) {
    if ($admin_role != 1) {

        redirect("../index.php", "you are not authorised to access this page");
    }
} else {

    redirect("../login.php", "Login to continue");
}
