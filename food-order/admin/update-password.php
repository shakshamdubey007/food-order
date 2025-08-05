<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper" <h1>Change Password</h1>
        <br> <br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }


        ?>

        <form action="" method="POST">

            <table class="tbl_30">
                <tr>
                    <td>Old Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
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
    // echo "clicked";
    //1. Get THe data from form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);



    //2. check whether the user with current id and current password exists or noT
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password= '$current_password' ";

    //execute the query
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //echo "User Found";
            if ($new_password == $confirm_password)
                 
            {
             $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id
                    ";
                    $res2 = mysqli_query($conn, $sql2);
                    if ($res2 == true) 
                    {

                $_SESSION['Change-pwd'] = "<div class='success'>Password changed Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
                    }
                    else
                        {
                $_SESSION['Change-pwd'] = "<div class='error'>Failed To Change Password.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
                        }
            } 

            else
             {

                $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
             }

        }
    } else {
        $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }


}

//3. check whether the new password and confirm password match or not

//4. change password if all is true



?>

<?php include('partials/footer.php'); ?>