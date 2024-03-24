<?php 
    include('../config/constants.php');

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql = "DELETE FROM dish_product WHERE dish_id=$id";
        $res = mysqli_query($conn, $sql);

        $sql2 = "DELETE FROM dishes WHERE id=$id";
        $res2 = mysqli_query($conn, $sql2);

        if($res && $res2)
        {
            $_SESSION['delete'] = "<div id='tempDiv' class='success'>Dish Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-dishes.php');
        }
        else
        {
            $_SESSION['delete'] = "<div id='tempDiv' class='error'>Failed to Delete Dish.</div>";
            header('location:'.SITEURL.'admin/manage-dishes.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div id='tempDiv' class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-dishes.php');
    }
?>