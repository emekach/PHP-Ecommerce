<?php

session_start();

include('../config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_POST['add_category_btn'])) {

    // Check if any required fields are empty
    $required_fields = ['name', 'slug', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'image'];
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . " is required.";
        }
    }

    // If there are any errors, redirect back to the form page with error messages
    if (!empty($errors)) {
        $error_message = implode(" ", $errors);
        redirect("add-category.php", $error_message);
    }

    $name = mysqli_real_escape_string($con, strip_tags($_POST['name']));
    $slug = mysqli_real_escape_string($con, strip_tags($_POST['slug']));
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $meta_title = mysqli_real_escape_string($con, strip_tags($_POST['meta_title']));
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status =  isset($_POST['status']) ? 1 : 0;
    $popular = isset($_POST['popular']) ? 1 : 0;

    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_path = $path . '/' . $filename;

    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array(strtolower($image_ext), $allowed_extensions)) {

        if (move_uploaded_file($tmp_name, $target_path)) {


            $stmt = $con->prepare("INSERT INTO categories (name,slug, description, meta_title,meta_description,meta_keywords,status,popular,image) VALUES(?,?,?,?,?,?,?,?,?)");

            $stmt->bind_param("ssssssiis", $name, $slug, $description, $meta_title, $meta_description, $meta_keywords, $status, $popular, $filename);

            if ($stmt->execute()) {

                redirect("add-category.php", "Category Added Successfully");
            } else {
                redirect("add-category.php", "Failed to add Category");
            }

            $stmt->close();
        } else {

            redirect("add-category.php", "Failed to move uploaded file");
        }
    } else {

        redirect("add-category.php", "Invalid FIle extension");
    }
}
