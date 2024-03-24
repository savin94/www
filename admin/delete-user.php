<?php 
    include('../config/constants.php');

    $id = $_GET['id'];

    //2. Create SQL Query to Delete Admin
    $sql = "DELETE FROM users WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        $_SESSION['delete'] = "<div id='tempDiv' class='success'>User Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-users.php');
    }
    else
    {
        $_SESSION['delete'] = "<div id='tempDiv' class='error'>Failed to Delete User. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/manage-users.php');
    }
?>