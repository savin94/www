<?php 
    include('../config/constants.php');

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM dishes WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Dish Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-dishes.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Dish.</div>";
            header('location:'.SITEURL.'admin/manage-dishes.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-dishes.php');
    }
?>