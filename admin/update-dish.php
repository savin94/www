<?php include('partials/menu.php'); ?>

<?php 
    //CHeck whether id is set or not 
    if(isset($_GET['id']))
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL Query to Get the Selected Food
        $sql2 = "SELECT * FROM dishes WHERE id=$id";
        //execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //Get the Individual Values of Selected Food
        $name = $row2['name'];
        $grams = $row2['grams'];
        $price = $row2['price'];
        $image_address = $row2['image_address'];
        $type = $row2['type'];
        $is_available = $row2['is_available'];
    }
    else
    {
        //Redirect to Manage Food
        header('location:'.SITEURL.'admin/manage-dishes.php');
    }
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-80">

            <tr>
                <td>Name: </td>
                <td>
                    <input class="input-field" type="text" name="title" value="<?php echo $name; ?>">
                </td>
            </tr>

            <tr>
                <td>Grams: </td>
                <td>
                    <input class="input-field" type="number" name="grams" value="<?php echo $grams; ?>">
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Image Address:</td>
                <td>
                    <input class="input-field" type="text" name="image_address" value="<?php echo $image_address; ?>">
                </td>
            </tr>
            <tr>
                <td>Select Type:</td>
                <td>
                    <?php
                    // Table and column name
                    $tableName = "dishes";
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

                    <select class="input-field" name="menu_type">
                        <?php foreach ($enumOptions as $option) : ?>
                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Product:</td>
                <td>
                    <select class="input-field" name="category">
                        <?php
                        $sql = "SELECT * FROM products";

                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);

                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $name = $row['name'];

                                ?>

                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>

                                <?php
                            }
                        } else {
                            ?>
                            <option value="0">No Products Found</option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Is available:</td>
                <td>
                    <input  <?php if($is_available=="Yes") {echo "checked";} ?> type="radio" name="is_available" value="Yes"> Yes
                    <input <?php if($is_available=="No") {echo "checked";} ?> type="radio" name="is_available" value="No"> No
                </td>
            </tr>
        </table>
        
        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";

                //1. Get all the details from the form
                $id = $_POST['id'];
                $name = $_POST['name'];
                $grams = $_POST['grams'];
                $price = $_POST['price'];
                $image_address = $_POST['image_address'];
                $type = $_POST['type'];
                $is_available = $_POST['is_available'];

                //4. Update the Food in Database
                $sql3 = "UPDATE tbl_food SET 
                    name = '$name',
                    grams = '$grams',
                    price = '$price',
                    image_address = '$image_address',
                    type = '$type',
                    is_available = '$is_available',
                    WHERE id=$id
                ";

                //Execute the SQL Query
                $res3 = mysqli_query($conn, $sql3);

                //CHeck whether the query is executed or not 
                if($res3==true)
                {
                    //Query Exectued and Food Updated
                    $_SESSION['update'] = "<div class='success'>Dish Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-dishes.php');
                }
                else
                {
                    //Failed to Update Food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Dish.</div>";
                    header('location:'.SITEURL.'admin/manage-dishes.php');
                }

                
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>