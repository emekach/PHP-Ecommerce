<?php
session_start();

include('../config/dbcon.php');
include('myfunctions.php');

if (isset($_POST['register_btn'])) {

    $name = mysqli_real_escape_string($con, strip_tags($_POST['name']));
    $phone = mysqli_real_escape_string($con, strip_tags($_POST['phone']));
    $email = mysqli_real_escape_string($con, strip_tags($_POST['email']));
    $password = mysqli_real_escape_string($con, strip_tags($_POST['password']));
    $cpassword = mysqli_real_escape_string($con, strip_tags($_POST['cpassword']));


    $email_check_query = "SELECT email FROM users WHERE email= ?";
    $stmt = $con->prepare($email_check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        redirect("../register.php", "Email Already exists in database");
    } else {
        if ($password == $cpassword) {

            $insert_query = "INSERT INTO users (name,phone,email,password) VALUES (?,?,?,?)";
            $stmt = $con->prepare($insert_query);
            $stmt->bind_param("ssss", $name, $phone, $email, $password);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {

                redirect("../login.php", "Registered Successfully");
            } else {

                redirect("../register.php", "Something went wrong");
            }
        } else {

            redirect("../register.php", "Passwords do not match");
        }

        $con->close();
    }
}


if (isset($_POST['login_btn'])) {

    $email = mysqli_real_escape_string($con, strip_tags($_POST['email']));
    $password = mysqli_real_escape_string($con, strip_tags($_POST['password']));

    $login_query = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $con->prepare($login_query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['auth'] = true;

        $userdata = $result->fetch_assoc();
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

    $con->close();
}
