<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['userId'];
$productId = (int) $_GET['id'];

$db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $query = "SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    
    if($cartResult->num_rows > 0){
        $query = "UPDATE shopping_cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    } else{
        $quantity = 1;
        $query = "INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iii", $userId, $productId, $quantity);
        $stmt->execute();
    }
}

header('Location: cart.php'); 
exit;



