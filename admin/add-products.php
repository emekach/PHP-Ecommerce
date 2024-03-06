<?php


include('includes/header.php');

include('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Products</h4>
                </div>

                <div class="card-body">

                    <form action="code.php" method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-12">
                                <label class="mb-0"> Select Category </label>
                                <select class="form-select mb-2" name="category_id">
                                    <option selected>Select Category</option>

                                    <?php
                                    $get_category = getAll("categories");
                                    if (!empty($get_category)) {

                                        foreach ($get_category as $item) { ?>
                                            <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                    <?php
                                        }
                                    } else {
                                        echo "No Categoty Available";
                                    }

                                    ?>



                                </select>
                            </div>


                            <div class="col-md-6">
                                <label class="mb-0"> Name </label>
                                <input type="text" name="name" placeholder="Enter Product Name" class="form-control mb-2">
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0">Slug </label>
                                <input type="text" name="slug" placeholder="Enter Slug" class="form-control mb-2">
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0">Small Description </label>
                                <textarea name="small_description" rows="3" class="form-control mb-2" placeholder="Enter Small Description"></textarea>

                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Description </label>
                                <textarea name="description" rows="3" class="form-control mb-2" placeholder="Enter Description"></textarea>

                            </div>

                            <div class="col-md-6">
                                <label class="mb-0"> Original Price </label>
                                <input type="text" name="original_price" placeholder="Enter Original Price" class="form-control mb-2">
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0">Selling Price </label>
                                <input type="text" name="selling_price" placeholder="Enter Selling Price" class="form-control mb-2">
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0">Upload Image </label>
                                <input type="file" name="image" class="form-control mb-2">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-0">Quantity </label>
                                    <input type="number" name="qty" placeholder="Enter Quantity" class="form-control mb-2">
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-0"> Status</label> <br>
                                    <input type="checkbox" name="status">
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-0"> Trending</label> <br>
                                    <input type="checkbox" name="trending">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Title </label>
                                <input type="text" name="meta_title" placeholder="Enter Meta Title" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Description </label>
                                <textarea name="meta_description" rows="3" class="form-control mb-2" placeholder="Enter Meta Description"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Keywords </label>
                                <textarea name="meta_keywords" rows="3" class="form-control mb-2" placeholder="Enter Meta Keywords"></textarea>
                            </div>


                            <div class="col-md-12">
                                <button type="submit" name="add_product_btn" class="btn btn-primary"> Upload Product</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>


<?php include('includes/footer.php'); ?>