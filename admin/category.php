<?php


include('includes/header.php');

include('../middleware/adminMiddleware.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Categories</h4>
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
                            </tr>

                        </thead>

                        <tbody>
                            <?php
                            $category = getAll("categories");

                            if (!empty($category)) {

                                foreach ($category as $row) { ?>
                                    <tr>

                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td>
                                            <img src="../uploads/<?= $row['image']; ?>" alt="<?= $row['image']; ?>" width="50px" height="50px">
                                        </td>
                                        <td><?= $row['status'] == '0' ? "Visible" : "Hidden"; ?></td>
                                        <td>
                                            <a href="edit-category.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
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