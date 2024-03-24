<?php include('partials/menu.php'); ?>
    <style>
        <?php include '../css/admin.scss'; ?>
    </style>
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Product</h1>

            <br/>
            <?php

            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['remove'])) {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['no-category-found'])) {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if (isset($_SESSION['failed-remove'])) {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }

            echo "<script>
                    setTimeout(function(){
                        var element = document.getElementById('tempDiv');
                        if (element) {
                            element.style.transition = 'opacity 1s';
                            element.style.opacity = '0';
                            setTimeout(function(){
                                element.parentNode.removeChild(element);
                            }, 1000);
                        }
                    }, 2000);
                  </script>";
            ?>
            <br>

            <a href="<?php echo SITEURL; ?>admin/add-product.php" class="btn-primary">Add Product</a>

            <br/><br/><br/>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>

                <?php

                //Query to Get all CAtegories from Database
                $sql = "SELECT * FROM products";

                //Execute Query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Create Serial Number Variable and assign value as 1
                $sn = 1;

                //Check whether we have data in database or not
                if ($count > 0) {
                    //We have data in database
                    //get the data and display
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $type = $row['type'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $name; ?></td>

                            <td><?php echo $type; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $id; ?>"
                                   class="btn-secondary" style="padding: 2%">Update Product</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-product.php?id=<?php echo $id; ?>"
                                   class="btn-danger" style="padding: 2%" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</a>
                            </td>
                        </tr>

                        <?php

                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="6">
                            <div class="error">No Product Added.</div>
                        </td>
                    </tr>

                    <?php
                }

                ?>
            </table>
        </div>
    </div>

<?php include('partials/footer.php'); ?>