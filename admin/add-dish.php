<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>

            <br><br>

            <?php
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            //        enum Types
            //        {
            //            case starters;
            //            case main_course;
            //            case deserts;
            //            case drinks;
            //        }
            //        ?>

            <form action="" method="POST" enctype="multipart/form-data">

                <table class="tbl-80">

                    <tr>
                        <td>Name:</td>
                        <td>
                            <input class="input-field" type="text" name="name" placeholder="Name of the dish">
                        </td>
                    </tr>

                    <tr>
                        <td>Grams:</td>
                        <td>
                            <input class="input-field" type="number" name="grams">
                        </td>
                    </tr>

                    <tr>
                        <td>Price:</td>
                        <td>
                            <input class="input-field" type="number" name="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Image Address:</td>
                        <td>
                            <input class="input-field" type="text" name="image_address">
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
                            <input type="radio" name="is_available" value="Yes"> Yes
                            <input type="radio" name="is_available" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Dish" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>


            <?php

            //CHeck whether the button is clicked or not
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $grams = $_POST['grams'];
                $price = $_POST['price'];
                $image_address = $_POST['image_address'];
                $type = $_POST['type'];
                $is_available = $_POST['is_available'];

                if (isset($_POST['is_available'])) {
                    $featured = $_POST['is_available'];
                } else {
                    $featured = "No";
                }

                $sql2 = "INSERT INTO dishes SET 
                    name = '$name',
                    grams = '$grams',
                    price = '$price',
                    image_address = '$image_address',
                    type = '$type',
                    is_available = '$is_available'
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //CHeck whether data inserted or not
                //4. Redirect with MEssage to Manage Food page
                if ($res2 == true) {
                    //Data inserted Successfullly
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('location:' . SITEURL . 'admin/manage-dishes.php');
                } else {
                    //FAiled to Insert Data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    header('location:' . SITEURL . 'admin/manage-dishes.php');
                }
            }

            ?>
        </div>
    </div>

<?php include('partials/footer.php'); ?>