<?php

session_start();

include('../config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_POST['add_category_btn'])) {

    // Validate input fields
    $required_fields = ['name', 'slug', 'description', 'meta_title', 'meta_description', 'meta_keywords'];
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "Fields are required.";
        }
    }

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
    $status =  isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_path = $path . '/' . $filename;

    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array(strtolower($image_ext), $allowed_extensions)) {

        if (move_uploaded_file($tmp_name, $target_path)) {


            $stmt = $con->prepare("INSERT INTO categories (name,slug,description,meta_title,meta_description,meta_keywords,status,popular,image) VALUES(?,?,?,?,?,?,?,?,?)");

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


if (isset($_POST['update_category_btn'])) {

    $category_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($con, strip_tags($_POST['name']));
    $slug = mysqli_real_escape_string($con, strip_tags($_POST['slug']));
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $meta_title = mysqli_real_escape_string($con, strip_tags($_POST['meta_title']));
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status =  isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    $update_filename = !empty($new_image) ? $new_image : $old_image;

    $path = "../uploads";
    $filename = time() . '.' . $image_ext;
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_path = $path . '/' . $new_image;


    $update_query = "UPDATE categories SET name=?, slug=?, description=? ,meta_title=? ,meta_description=? ,meta_keywords=? ,status=? ,popular=? ,image=? WHERE id=?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("ssssssiisi", $name, $slug, $description, $meta_title, $meta_description, $meta_keywords, $status, $popular, $update_filename, $category_id);

    if ($stmt->execute()) {

        if (!empty($_FILES['image']['name'])) {
            move_uploaded_file($tmp_name, $target_path);
            if (file_exists("../uploads/" . $old_image)) {

                unlink("../uploads/" . $old_image);
            }
        }
        redirect("edit-category.php?id=$category_id", "Category Updated Successfully");
    }


    $stmt->close();
}
