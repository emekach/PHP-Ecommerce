<?php


require('includes/header.php');

require('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Products</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php
                            $products = getAll("products");

                            if (!empty($products)) {

                                foreach ($products as $row) { ?>
                                    <tr>

                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td>
                                            <img src="../uploads/products/<?= $row['image']; ?>" alt="<?= $row['image']; ?>" width="50px" height="50px">
                                        </td>
                                        <td><?= $row['status'] == '0' ? "Visible" : "Hidden"; ?></td>
                                        <td>
                                            <a href="edit-products.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>

                                        </td>
                                        <td>
                                            <form action="code.php" method="POST">

                                                <input type="hidden" name="products_id" value="<?= $row['id']; ?>">
                                                <button type="submit" class="btn  btn-danger" name="delete_products_btn">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                            <?php
                                }
                            } else {
                                echo "No records found";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<?php include('includes/footer.php'); ?>