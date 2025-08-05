<?php
require_once 'config/constants.php'; // includes session_start and DB

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];

    // Only remove the item if it belongs to the current user (security!)
    $sql = "DELETE FROM tbl_cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cart_id, $user_id);
    
    if ($stmt->execute()) {
        header("Location: cart.php"); // success
        exit();
    } else {
        echo "Error removing item: " . $stmt->error;
    }
} else {
    echo "Invalid request";
}
