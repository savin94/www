<?php include('partials/menu.php'); ?>

<?php
if (isset($_GET['id'])) {
    //Get all the details
    $id = $_GET['id'];

    $sql2 = "SELECT * FROM dishes WHERE id=$id";

    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);

    $name = $row2['name'];
    $grams = $row2['grams'];
    $price = $row2['price'];
    $image_address = $row2['image_address'];
    $type = $row2['type'];
    $is_available = $row2['is_available'];

   } else {
    header('location:' . SITEURL . 'admin/manage-dishes.php');
}
?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Dish</h1>
            <br><br>

            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <table class="tbl-80">
                    <tr>
                        <td>Name:</td>
                        <td>
                            <input class="input-field" type="text" name="name" value="<?php echo $name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Grams:</td>
                        <td>
                            <input class="input-field" type="number" name="grams" value="<?php echo $grams; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Price:</td>
                        <td>
                            <input class="input-field" type="number" name="price" value="<?php echo $price; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Image Address:</td>
                        <td>
                            <input class="input-field" type="text" name="image_address"
                                   value="<?php echo $image_address; ?>">
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

                            <select class="input-field" name="type">
                                <?php foreach ($enumOptions as $option) : ?>
                                    <option <?php echo $type == $option ? "selected" : "" ?>
                                            value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Select Product:</td>
                        <td>
                            <select class="input-field" name="products[]" id="products" multiple>
                                <!-- Fetch products from database and populate options -->
                                <?php
                                // Query to fetch products
                                $sql = "SELECT id, name FROM products";
                                $result = $conn->query($sql);
                                $productIds = array();

                                $joinSql = "SELECT * FROM dish_product WHERE dish_id=$id";
                                $joinRes2 = mysqli_query($conn, $joinSql);
                                while ($joinRow = mysqli_fetch_assoc($joinRes2)) {
                                    $productIds[] = $joinRow['product_id'];
                                }

                                // Populate options
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo in_array($row["id"], $productIds) ?
                                            "<option selected value='" . $row["id"] . "'>" . $row["name"] . "</option>"
                                            : "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Is available:</td>
                        <td>
                            <input <?php echo $is_available == "Yes" ? "checked" : "" ?> type="radio"
                                                                                         name="is_available"
                                                                                         value="Yes"> Yes
                            <input <?php echo $is_available == "No" ? "checked" : "" ?>type="radio" name="is_available"
                                   value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" value="Update Dish" style="padding: 4%;"
                                   class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $grams = $_POST['grams'];
                $price = $_POST['price'];
                $image_address = $_POST['image_address'];
                $type = $_POST['type'];
                $is_available = $_POST['is_available'];

                //4. Update the Food in Database
                $sql3 = "UPDATE dishes SET 
                    name = '$name',
                    grams = '$grams',
                    price = '$price',
                    image_address = '$image_address',
                    type = '$type',
                    is_available = '$is_available'
                    WHERE id=$id
                ";

                $res3 = mysqli_query($conn, $sql3);
                $selected_products = $_POST['products'];

                if ($res2) {
                    // Remove existing associations for the dish
                    $sql_delete = "DELETE FROM dish_product WHERE dish_id = $id";
                    $result_delete = $conn->query($sql_delete);

                    if ($result_delete) {
                        // Loop through selected products and insert associations into junction table
                        foreach ($selected_products as $product_id) {
                            $sql_insert = "INSERT INTO dish_product (dish_id, product_id) VALUES ($id, $product_id)";
                            $result_insert = $conn->query($sql_insert);

                            // Handle errors if needed
                            if (!$result_insert) {
                                // Handle insertion error
                                echo "Error inserting association for product ID $product_id";
                            }
                        }
                    } else {
                        // Handle deletion error
                        echo "Error deleting existing associations for dish ID $id";
                    }
                }

                if ($res3) {
                    $_SESSION['update'] = "<div id='tempDiv' class='success'>Dish Updated Successfully.</div>";
                    echo "<script>location.href = '" . SITEURL . "admin/manage-dishes.php';</script>";
                } else {
                    //Failed to Update Food
                    $_SESSION['update'] = "<div id='tempDiv' class='error'>Failed to Update Dish.</div>";
                    header('location:' . SITEURL . 'admin/manage-dishes.php');
                }
            }
            ?>
        </div>
    </div>

<?php include('partials/footer.php'); ?>