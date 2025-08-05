<?php include('partials-front/menu.php'); ?>

 <?php
//session_start();
require_once 'config/constants.php'; // Your DB connection file session already started under it

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the user
$sql = "SELECT id, food_name, price, quantity, added_at FROM tbl_cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 70%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        .btn { padding: 6px 12px; background-color: #f44336; color: white; border: none; cursor: pointer; }
        .btn:hover { background-color: #d32f2f; }
    </style>
</head>
<body>

<h2>Your Cart</h2>
<table>
    <tr>
        <th>Food Name</th>
        <th>Price (₹)</th>
        <th>Quantity</th>
        <th>Subtotal (₹)</th>
        <th>Added At</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()):
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
    ?>
    <tr>
        <td><?= htmlspecialchars($row['food_name']) ?></td>
        <td><?= number_format($row['price'], 2) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= number_format($subtotal, 2) ?></td>
        <td><?= $row['added_at'] ?></td>
        <td>
            <form method="POST" action="remove_item.php">
                <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn">Remove</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h3 style="text-align:center;">Total: ₹<?= number_format($total, 2) ?></h3>
<div style="text-align:center;">
<a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $row['food_id']; ?>" class="btn btn-primary">Proceed To Checkout</a>

  
</form>

</div>

</body>
</html>



