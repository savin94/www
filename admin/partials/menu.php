<?php
include('../config/constants.php');
include('login-check.php');
?>
<html>
<head>
    <title>Restaurant Website - Home Page</title>
    <link rel="stylesheet" href="../css/admin.scss">
</head>

<body>
<!-- Menu Section Starts -->
<div class="menu text-center">
    <div class="wrapper">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="manage-users.php">Users</a></li>
            <li><a href="manage-products.php">Products</a></li>
            <li><a href="manage-dishes.php">Dishes</a></li>
            <li><a onclick="return confirm('Are you sure you want logout?')" href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
<!-- Menu Section Ends -->