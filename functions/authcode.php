<?php
session_start();

include('../config/dbcon.php');
include('myfunctions.php');

if (isset($_POST['register_btn'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);


    $email_check_query = "SELECT email FROM users WHERE email= '$email'";
    $email_check_query_run = mysqli_query($con, $email_check_query) or die(mysqli_error($con));

    if (mysqli_num_rows($email_check_query_run) > 0) {

        redirect("../register.php", "Email Already exists in database");
    } else {
        if ($password == $cpassword) {

            $insert_query = "INSERT INTO users (name,phone,email,password) VALUES ('$name','$phone','$email','$password')";
            $insert_query_run = mysqli_query($con, $insert_query) or die(mysqli_error($con));

            if ($insert_query_run) {

                redirect("../login.php", "Registered Successfully");
            } else {

                redirect("../register.php", "Something went wrong");
            }
        } else {

            redirect("../register.php", "Passwords do not match");
        }
    }
}


if (isset($_POST['login_btn'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $login_query_run = mysqli_query($con, $login_query) or die(mysqli_error($con));

    if (mysqli_num_rows($login_query_run) > 0) {

        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $username = $userdata['name'];
        $useremail = $userdata['email'];
        $role_as = $userdata['role_as'];

        // print_r($userdata);

        $_SESSION['auth_user'] = [
            'name' => $username,
            'email' => $useremail,
        ];

        $_SESSION['role_as'] = $role_as;

        if ($role_as == 1) {

            redirect("../admin/index.php", "Welcome to Dashboard");
        } else {

            redirect("../index.php", "Logged In Successfully");
        }
    } else {

        redirect("../login.php", "Invalid credentials");
    }
}
