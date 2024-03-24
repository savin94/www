<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.scss">
    </head>
    <style>
        <?php include '../css/admin.scss'; ?>
    </style>
    <body class="login-wrapper">

        <div class="login">
            <h1 class="text-center" style="">Login</h1>
            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login Form Starts HEre -->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input class="input-field" type="text" name="username" style="margin-top: 10px" placeholder="Enter Username"><br><br>

            Password: <br>
            <input class="input-field" type="password" name="password" style="margin-top: 10px" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" style="padding: 5%; width: 100%" class="btn-primary">
            <br><br>
            </form>
            <!-- Login Form Ends HEre -->

            <p class="text-center">Created By - Savin Bratanov</a></p>
        </div>

    </body>
</html>

<?php 

    if(isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count==1)
        {
            $_SESSION['login'] = "<div id='tempDiv' class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;
            echo "<script>location.href = '" . SITEURL . "admin/';</script>";
        }
        else
        {
            $_SESSION['login'] = "<div id='tempDiv' class='error text-center'>Username or Password did not match.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>