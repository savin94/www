<?php 
    include('../config/constants.php');

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql = "DELETE FROM products WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Product Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-products.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Product.</div>";
            header('location:'.SITEURL.'admin/manage-products.php');
        }
    }
    else
    {
        header('location:'.SITEURL.'admin/manage-products.php');
    }
?>