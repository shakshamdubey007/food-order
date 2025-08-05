<?php
include('partials-front/menu.php');
require_once('config/constants.php');
//session_start();

if (isset($_POST['submit'])) {
    // 1. Collect and sanitize inputs
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    // 2. Fetch user by username
    $sql = "SELECT id, password, full_name FROM tbl_user WHERE username='$username'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        // 3. Verify password
        if (password_verify($password, $row['password'])) {
            // 4. Set session and redirect
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['login_error'] = "Invalid password.";
        }
    } else {
        $_SESSION['login_error'] = "User not found.";
    }
}
?>

<section class="login text-center">
  <div class="container">
    <h2>Login to Your Account</h2>

    <?php
      if (isset($_SESSION['login_error'])) {
        echo "<div class='error'>".$_SESSION['login_error']."</div>";
        unset($_SESSION['login_error']);
      }
    ?>

    <form action="" method="POST" class="order">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" name="submit" value="Login" class="btn btn-primary">
    </form>
  </div>
</section>

<?php include('partials-front/footer.php'); ?>
