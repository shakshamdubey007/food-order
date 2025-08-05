<?php include('../config/constants.php');  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/adminn.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
         <br><br>

        <?php
          if(isset($_SESSION['login'])) 
          {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
          }
          
          if(isset($_SESSION['no-login-message']))
          {
            echo $_SESSION['no-login-message'];
            unset ($_SESSION['no-login-message']);
          }
        
        
        ?>
        <br> <br>


        <!-- Login Form Starts Here -->
         <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" palceholder="Enter Username"><br> <br>

            Password: <br> 
            <input type="password" name="password" placeholder="Enter Password"><br> <br>
            
            <input type="submit" name="submit" value="login" class="btn-primary">
          <br><br>
         </form>
        <!-- Login Form Ends Here -->
        <p class="text-center"> Created By - <a href="www.divyam.com">Divyam Dwivedi</a></p>
    </div>
</body>
</html>

<?php 

    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {

       $username = $_POST['username'];
       $password = md5($_POST['password']);

       $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
       $res=mysqli_query($conn,$sql);

       $count=mysqli_num_rows($res);
       if($count==1)    
       {
          $_SESSION['login']= "<div class='success'>Login Successful.</div>";
        $_SESSION['user']= $username;


          header('location:'.SITEURL.'admin/');

       }
       else
        {
         $_SESSION['login']= "<div class='error text-center'>Username or password did not match.</div>";
          header('location:'.SITEURL.'admin/login.php');
       }

    }

?>
