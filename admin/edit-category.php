<?php


require('includes/header.php');

require('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {

                $id = $_GET['id'];

                $category = getById("categories", $id);
                if ($category->num_rows > 0) {
                    $data = $category->fetch_assoc();

            ?>

                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Category</h4>
                        </div>

                        <div class="card-body">

                            <form action="code.php" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="category_id" value="<?= $data['id'] ?>">
                                        <label> Name </label>
                                        <input type="text" name="name" value="<?= $data['name'] ?>" placeholder="Enter Category Name" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Slug </label>
                                        <input type="text" name="slug" value="<?= $data['slug'] ?>" placeholder="Enter Slug" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Description </label>
                                        <textarea name="description" rows="3" class="form-control" placeholder="Enter Description"><?= $data['description'] ?></textarea>

                                    </div>
                                    <div class="col-md-12">
                                        <label>Upload Image </label>
                                        <input type="file" name="image" class="form-control">
                                        <br>
                                        <label>Current Image</label>
                                        <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                        <img src="../uploads/<?= $data['image'] ?>" alt="<?= $data['image'] ?>" width="50px" height="50px">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Meta Title </label>
                                        <input type="text" name="meta_title" value="<?= $data['meta_title'] ?>" placeholder="Enter Meta Title" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Meta Description </label>
                                        <textarea name="meta_description" rows="3" class="form-control" placeholder="Enter Meta Description"><?= $data['meta_description'] ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Meta Keywords </label>
                                        <textarea name="meta_keywords" rows="3" class="form-control" placeholder="Enter Meta Keywords"><?= $data['meta_keywords'] ?></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label> Status</label>
                                        <input type="checkbox" <?= $data['status'] ? 'checked' : '' ?> name="status">
                                    </div>
                                    <div class="col-md-6">
                                        <label> Popular</label>
                                        <input type="checkbox" <?= $data['popular'] ? 'checked' : '' ?> name="popular">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="update_category_btn" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
            <?php
                } else {
                    echo "Category not found";
                }
            } else {
                echo "Id Missing from url";
            }
            ?>

        </div>

    </div>
</div>


<?php include('includes/footer.php'); ?>