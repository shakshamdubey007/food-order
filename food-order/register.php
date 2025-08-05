<?php
include('partials-front/menu.php');
require_once('config/constants.php');
//session_start();

if (isset($_POST['submit'])) {
    // 1. Collect and sanitize inputs
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $username  = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password  = trim($_POST['password']);
    $confirm   = trim($_POST['confirm_password']);

    // 2. Validate fields
    if ($full_name == "" || $username == "" || $password == "" || $confirm == "") {
        $_SESSION['register_error'] = "All fields are required.";
    } elseif ($password !== $confirm) {
        $_SESSION['register_error'] = "Passwords do not match.";
    } else {
        // 3. Check for existing username
        $check_sql = "SELECT id FROM tbl_user WHERE username='$username'";
        $res_check = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($res_check) > 0) {
            $_SESSION['register_error'] = "Username already taken.";
        } else {
            // 4. Hash password and insert
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO tbl_user (full_name, username, password)
                    VALUES ('$full_name', '$username', '$hashed_pw')";
            
            if (mysqli_query($conn, $sql)) {
                $_SESSION['register_success'] = "Registration successful. Please log in.";
                header('Location: login.php');
                exit;
            } else {
                $_SESSION['register_error'] = "Database error. Try again.";
            }
        }
    }
}
?>

<section class="register text-center">
  <div class="container">
    <h2>Create Your Account</h2>

    <?php
      if (isset($_SESSION['register_error'])) {
        echo "<div class='error'>".$_SESSION['register_error']."</div>";
        unset($_SESSION['register_error']);
      }
      if (isset($_SESSION['register_success'])) {
        echo "<div class='success'>".$_SESSION['register_success']."</div>";
        unset($_SESSION['register_success']);
      }
    ?>

    <form action="" method="POST" class="order">
      <input type="text" name="full_name" placeholder="Your Full Name" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <input type="submit" name="submit" value="Register" class="btn btn-primary">
    </form>
  </div>
</section>

<?php include('partials-front/footer.php'); ?>
