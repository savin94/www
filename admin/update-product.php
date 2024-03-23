<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Product</h1>

        <br><br>


        <?php 
        
            //Check whether the id is set or not
            if(isset($_GET['id']))
            {
                //Get the ID and all other details
                //echo "Getting the Data";
                $id = $_GET['id'];
                //Create SQL Query to get all other details
                $sql = "SELECT * FROM products WHERE id=$id";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count the Rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $name = $row['name'];
                    $type = $row['type'];
                }
                else
                {
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-products.php');
                }

            }
            else
            {
                //redirect to Manage CAtegory
                header('location:'.SITEURL.'admin/manage-products.php');
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-80">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input class="input-field" type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Select Type:</td>
                    <td>
                        <?php
                        // Table and column name
                        $tableName = "products";
                        $columnName = "type";

                        // Query to describe table structure
                        $sql = "DESCRIBE $tableName";
                        $result = $conn->query($sql);

                        // Array to store enum options
                        $enumOptions = [];

                        // Loop through the result to find the column
                        while ($row = $result->fetch_assoc()) {
                            if ($row['Field'] == $columnName && strpos($row['Type'], 'enum') !== false) {
                                // Extract the enum options from the "Type" column
                                preg_match_all("/'([^']+)'/", $row['Type'], $matches);
                                $enumOptions = $matches[1];
                                break;
                            }
                        }
                        ?>
                        <select class="input-field" name="type">
                            <?php foreach ($enumOptions as $option) : ?>
                                <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Product" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1. Get all the values from our form
                $id = $_POST['id'];
                $name = $_POST['name'];
                $type = $_POST['type'];

                $sql2 = "UPDATE products SET 
                    name = '$name',
                    type = '$type',
                    WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                if($res2==true)
                {
                    //Category Updated
                    $_SESSION['update'] = "<div class='success'>Product Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-products.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Product.</div>";
                    header('location:'.SITEURL.'admin/manage-products.php');
                }

            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>