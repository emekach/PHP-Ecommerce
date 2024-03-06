<?php


require('includes/header.php');

require('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Category</h4>
                </div>

                <div class="card-body">

                    <form action="code.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-6">
                                <label> Name </label>
                                <input type="text" name="name" placeholder="Enter Category Name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Slug </label>
                                <input type="text" name="slug" placeholder="Enter SLug" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Description </label>
                                <textarea name="description" rows="3" class="form-control" placeholder="Enter Description"></textarea>

                            </div>
                            <div class="col-md-12">
                                <label>Upload Image </label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Meta Title </label>
                                <input type="text" name="meta_title" placeholder="Enter Meta Title" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Meta Description </label>
                                <textarea name="meta_description" rows="3" class="form-control" placeholder="Enter Meta Description"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label>Meta Keywords </label>
                                <textarea name="meta_keywords" rows="3" class="form-control" placeholder="Enter Meta Keywords"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label> Status</label>
                                <input type="checkbox" name="status">
                            </div>
                            <div class="col-md-6">
                                <label> Popular</label>
                                <input type="checkbox" name="popular">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="add_category_btn" class="btn btn-primary"> Add Category</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>


<?php include('includes/footer.php'); ?>