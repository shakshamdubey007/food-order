<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['no_access'] = "Access denied. Login required.";
    header('Location: ' . SITEURL . 'food-order/login.php');
    exit();
}
?>
