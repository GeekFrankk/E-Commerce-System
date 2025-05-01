<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['userId'];

$db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get all cart items
$query = "SELECT c.product_id, c.quantity, p.price 
          FROM shopping_cart c 
          JOIN products p ON c.product_id = p.product_id 
          WHERE c.user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Your cart is empty.";
    exit;
}

// Create order
$totalAmount = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $totalAmount += $row['price'] * $row['quantity'];
}

$orderQuery = "INSERT INTO orders (user_id, order_date, order_amount) VALUES (?, NOW(), ?)";
$stmt = $db->prepare($orderQuery);
$stmt->bind_param("id", $userId, $totalAmount);
$stmt->execute();
$orderId = $stmt->insert_id;

// Insert each item into order_items
$orderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($orderItemQuery);

$ststus = "pending";

foreach ($items as $item) {
    $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();
}

// Clear the shopping cart
$deleteCartQuery = "DELETE FROM shopping_cart WHERE user_id = ?";
$stmt = $db->prepare($deleteCartQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();

$db->close();

// Redirect or confirm
header("Location: order_success.html");
exit;



