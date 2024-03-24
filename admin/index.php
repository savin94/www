<?php include('partials/menu.php'); ?>
<style>
    <?php include '../css/admin.scss'; ?>
</style>
    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Dashboard</h1>
            <br>
            <?php
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
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
                <?php
                $sql2 = "SELECT * FROM dishes";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);
                if (mysqli_num_rows($res2) > 0) {
                    // Loop through each row of the result set
                    while ($row2 = mysqli_fetch_assoc($res2)) {
                        // Extract data from the current row
                        $id = $row2['id'];
                        $name = $row2['name'];
                        $grams = $row2['grams'];
                        $price = $row2['price'];
                        $image_address = $row2['image_address'];
                        $type = $row2['type'];
                        $is_available = $row2['is_available'];

                        // Output HTML for the card

                        echo '<div class="card-wrapper">';
                        echo '<div class="card">';
                        echo '<img src="' . $image_address . '" alt="' . $name . '" class="card-image">';
                        echo $is_available == "Yes" ?'<img src="icons/check.png" class="check-icon">' : '<img src="icons/xIcon.png" class="check-icon">';
                        echo '<div class="card-content">';
                        echo '<h2 class="card-title">' . $name . '</h2>';
                        echo '<p class="card-info">Type: ' . $type . '</p>';
                        echo '<p class="card-info">Grams: ' . $grams . '</p>';
                        echo '<p class="card-info">Price: $' . $price . '</p>';
                        echo '<p class="card-info">Availability: ' . $is_available . '</p>';
                        // Fetch associated products for the current dish
                        $sql_products = "SELECT p.name FROM products p INNER JOIN dish_product dp ON p.id = dp.product_id WHERE dp.dish_id = $id";
                        $res_products = mysqli_query($conn, $sql_products);

                        // Display associated products
                        $product_names = [];
                        while ($product = mysqli_fetch_assoc($res_products)) {
                            $product_names[] = $product['name'];
                        }
                        $products_string = implode(', ', $product_names);

                        // Display associated products
                        echo '<p class="card-info products-list">Products: ' . $products_string . '</p>';
                        echo '</div></div></div>';
                    }
                }
                ?>

            <div class="clearfix"></div>

        </div>
    </div>
    <!-- Main Content Setion Ends -->

<?php include('partials/footer.php') ?>