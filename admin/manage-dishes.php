<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Dishes</h1>

        <br /><br />

                <!-- Button to Add Admin -->
                <a href="<?php echo SITEURL; ?>admin/add-dish.php" class="btn-primary">Add Dish</a>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Grams</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Is available</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //Create a SQL Query to Get all the Food
                        $sql = "SELECT * FROM dishes";

                        //Execute the qUery
                        $res = mysqli_query($conn, $sql);

                        //Count Rows to check whether we have foods or not
                        $count = mysqli_num_rows($res);

                        //Create Serial Number VAriable and Set Default VAlue as 1
                        $sn=1;

                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $name = $row['name'];
                                $grams = $row['grams'];
                                $price = $row['price'];
                                $image_address = $row['image_address'];
                                $is_available = $row['is_available'];
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?>. </td>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $grams; ?></td>
                                    <td>$<?php echo $price; ?></td>
                                    <td>
                                        <?php  
                                            if($image_address=="")
                                            {
                                                echo "<div class='error'>Image not Added.</div>";
                                            }
                                            else
                                            {
                                                ?>
                                                <img src="<?php echo $image_address; ?>" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $is_available; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-dish.php?id=<?php echo $id; ?>" class="btn-secondary">Update Dish</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-dish.php?id=<?php echo $id; ?>" class="btn-danger">Delete Dish</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //Food not Added in Database
                            echo "<tr> <td colspan='7' class='error'> Dish not Added Yet. </td> </tr>";
                        }

                    ?>

                </table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>