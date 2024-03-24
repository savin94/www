<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Product</h1>

        <br><br>


        <?php 
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $sql = "SELECT * FROM products WHERE id=$id";

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    $row = mysqli_fetch_assoc($res);
                    $name = $row['name'];
                    $type = $row['type'];
                }
                else
                {
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-products.php');
                }

            }
            else
            {
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
                                <option <?php echo $type == $option ? "selected" : "" ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Product" style="padding: 4%;" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            if(isset($_POST['submit']))
            {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $type = $_POST['type'];

                $sql2 = "UPDATE products SET 
                    name = '$name',
                    type = '$type'
                    WHERE id='$id'";
                try {
                    $res2 = mysqli_query($conn, $sql2);
                } catch (mysqli_sql_exception $e) {
                    var_dump($e);
                    exit;
                }
                if($res2==true)
                {
                    //Category Updated
                    $_SESSION['update'] = "<div id='tempDiv' class='success'>Product Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-products.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div id='tempDiv' class='error'>Failed to Update Product.</div>";
                    header('location:'.SITEURL.'admin/manage-products.php');
                }

            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>