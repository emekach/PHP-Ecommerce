<?php

session_start();

require('../config/dbcon.php');
require('../functions/myfunctions.php');

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
        $error_message = "All Fields are required";
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

    if (!empty($new_image)) {
        // $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads";

    $tmp_name = $_FILES['image']['tmp_name'];
    $target_path = $path . '/' . $update_filename;


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
    } else {
        redirect("edit-category.php?id=$category_id", "Something Went Wrong");
    }


    $stmt->close();
}

if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);

    $category_query = "SELECT * FROM categories WHERE id=?";
    $stmt = $con->prepare($category_query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $category_result = $stmt->get_result();

    if ($category_result->num_rows > 0) {
        $row = $category_result->fetch_assoc();
        $image = $row['image'];

        $delete_query = "DELETE FROM categories WHERE id=?";
        $stmt = $con->prepare($delete_query);
        $stmt->bind_param("i", $category_id);
        if ($stmt->execute()) {

            if (file_exists("../uploads/" . $image)) {
                unlink("../uploads/" . $image);
            }
            redirect("category.php", "Category Deleted Successfully");
        } else {
            redirect("category.php", "Something went wrong");
        }
        $stmt->close();
    } else {

        redirect("category.php", "Category Doesnt exist");
    }
}

if (isset($_POST['add_product_btn'])) {

    $required_fields = ['category_id', 'name', 'slug', 'small_description', 'original_price', 'selling_price', 'qty', 'meta_title', 'meta_title', 'meta_description', 'meta_keywords'];

    $errors = [];

    foreach ($required_fields as $fields) {
        if (empty($_POST[$fields])) {
            $errors[] = ucfirst($fields) . " is required";
        }
    }
    if (!empty($errors)) {
        $error_message = implode("<br/>", $errors);
        redirect("add-products.php", $error_message);
    }

    $category_id = mysqli_real_escape_string($con, strip_tags($_POST['category_id']));
    $name = mysqli_real_escape_string($con, strip_tags($_POST['name']));
    $slug = mysqli_real_escape_string($con, strip_tags($_POST['slug']));
    $small_description = mysqli_real_escape_string($con, $_POST['small_description']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $original_price = mysqli_real_escape_string($con, strip_tags($_POST['original_price']));
    $selling_price = mysqli_real_escape_string($con, strip_tags($_POST['selling_price']));
    $qty = mysqli_real_escape_string($con, strip_tags($_POST['qty']));
    $meta_title = mysqli_real_escape_string($con, strip_tags($_POST['meta_title']));
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status =  isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $image = $_FILES['image']['name'];
    $path = "../uploads/products";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_path = $path . '/' . $filename;

    $allowed_extensions = ['jpg', 'png', 'gif', 'jpeg'];

    if (in_array(strtolower($image_ext), $allowed_extensions)) {
        if (move_uploaded_file($tmp_name, $target_path)) {

            $product_query = "INSERT INTO products (category_id,name,slug,small_description,description,original_price,selling_price,qty,meta_title,meta_description,meta_keywords,status,trending,image) VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $con->prepare($product_query);
            $stmt->bind_param("issssiiisssiis", $category_id, $name, $slug, $small_description, $description, $original_price, $selling_price, $qty, $meta_title, $meta_description, $meta_keywords, $status, $trending, $filename);
            if ($stmt->execute()) {

                redirect("add-products.php", "Product Added Successfully");
            } else {
                redirect("add-products.php", "Something went wrong!...Failed to add product");
            }
            $stmt->close();
        } else {
            redirect("add-products.php", "Failed to upload File");
        }
    } else {
        redirect("add-products.php", "Invalid File Extension");
    }
}
