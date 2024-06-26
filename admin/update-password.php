<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password</h1>
            <br><br>

            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            ?>

            <form action="" method="POST">

                <table class="tbl-80">
                    <tr>
                        <td>Current Password:</td>
                        <td>
                            <input class="input-field" type="password" name="current_password"
                                   placeholder="Current Password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password:</td>
                        <td>
                            <input class="input-field" type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password:</td>
                        <td>
                            <input class="input-field" type="password" name="confirm_password"
                                   placeholder="Confirm Password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>

                </table>

            </form>

        </div>
    </div>

<?php

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    $sql = "SELECT * FROM users WHERE id=$id AND password='$current_password'";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            if ($new_password == $confirm_password) {
                //Update the Password
                $sql2 = "UPDATE users SET 
                                password='$new_password' 
                                WHERE id=$id
                            ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //CHeck whether the query exeuted or not
                if ($res2 == true) {
                    //Display Succes Message
                    //REdirect to Manage Admin Page with Success Message
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully. </div>";
                    //Redirect the User
                    header('location:' . SITEURL . 'admin/manage-users.php');
                } else {
                    //Display Error Message
                    //REdirect to Manage Admin Page with Error Message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password. </div>";
                    //Redirect the User
                    header('location:' . SITEURL . 'admin/manage-users.php');
                }
            } else {
                //REdirect to Manage Admin Page with Error Message
                $_SESSION['pwd-not-match'] = "<div id='tempDiv' class='error'>Password Did not Patch. </div>";
                //Redirect the User
                header('location:' . SITEURL . 'admin/manage-users.php');

            }
        } else {
            $_SESSION['user-not-found'] = "<div id='tempDiv' class='error'>User Not Found. </div>";
            //Redirect the User
            header('location:' . SITEURL . 'admin/manage-users.php');
        }
    }
}

?>


<?php include('partials/footer.php'); ?>