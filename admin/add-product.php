<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Product</h1>

        <br><br>

        <?php 
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        ?>

        <br><br>

        <!-- Add CAtegory Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-80">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input class="input-field" type="text" name="name" />
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
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Add CAtegory Form Ends -->

        <?php 
        
            if(isset($_POST['submit']))
            {
                $name = $_POST['name'];
                $type = $_POST['type'];

                $sql = "INSERT INTO products SET 
                    name='$name',
                    type='$type'
                ";

                $res = mysqli_query($conn, $sql);

                if($res==true)
                {
                    //Query Executed and Category Added
                    $_SESSION['add'] = "<div class='success'>Product Added Successfully.</div>";
                    //Redirect to Manage Category Page
                    header('location:'.SITEURL.'admin/manage-products.php');
                }
                else
                {
                    //Failed to Add CAtegory
                    $_SESSION['add'] = "<div class='error'>Failed to Add Product.</div>";
                    //Redirect to Manage Category Page
                    header('location:'.SITEURL.'admin/add-product.php');
                }
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>