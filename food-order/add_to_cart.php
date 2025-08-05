<?php
require_once 'config/constants.php'; // includes session_start & db connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$food_id = $_POST['food_id'];
$food_name = $_POST['food_name'];
$price = $_POST['price'];
$quantity = (int)$_POST['quantity']; // convert to integer for safety

// Check if item already exists
$checkSql = "SELECT id, quantity FROM tbl_cart WHERE user_id = ? AND food_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $user_id, $food_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity
    $row = $result->fetch_assoc();
    $newQty = $row['quantity'] + $quantity;
    $updateSql = "UPDATE tbl_cart SET quantity = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ii", $newQty, $row['id']);
    $updateStmt->execute();
} else {
    // Insert new cart row
    $insertSql = "INSERT INTO tbl_cart (user_id, food_id, food_name, price, quantity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iisdi", $user_id, $food_id, $food_name, $price, $quantity);
    $stmt->execute();
}

// Redirect to cart
header("Location: cart.php");
exit();
