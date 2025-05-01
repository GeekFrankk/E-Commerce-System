<?php
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

$query = "SELECT sc.*, p.pname, p.price, p.image_path 
          FROM shopping_cart sc 
          JOIN products p ON sc.product_id = p.product_id 
          WHERE sc.user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $row['subtotal'] = $subtotal;
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Violet Cosmetics</title>
    <style>
        :root {
            --primary: #956aad;
            --primary-dark: #7a559a;
            --primary-light: #b68ecc;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
            --accent: #ff9cee;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--primary);
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: var(--white);
            text-align: center;
            margin-bottom: 15px;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 30px;
        }
        
        nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        nav a:hover {
            background-color: var(--primary-dark);
            color: var(--white);
        }
        
        main {
            margin: 30px 0;
        }
        
        h1 {
            color: var(--primary);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .cart-container {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .cart-table th {
            background-color: var(--primary-light);
            color: var(--white);
            text-align: left;
            padding: 12px 15px;
        }
        
        .cart-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .cart-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-img {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            object-fit: cover;
            margin-right: 15px;
            background-color: var(--primary-light);
        }
        
        .product-info {
            display: flex;
            align-items: center;
        }
        
        .product-name {
            font-weight: 600;
        }
        
        .quantity-input {
            width: 60px;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .remove-btn {
            background-color: transparent;
            color: #ff6b6b;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        
        .remove-btn:hover {
            color: #ff4757;
        }
        
        .cart-summary {
            margin-top: 30px;
            text-align: right;
        }
        
        .cart-total {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        
        .total-price {
            font-weight: bold;
            color: var(--primary);
            font-size: 1.4rem;
        }
        
        .btn {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: inline-block;
            font-size: 1rem;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            margin-right: 10px;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .empty-cart {
            text-align: center;
            padding: 40px 0;
        }
        
        .empty-cart p {
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: #666;
        }
        
        footer {
            background-color: var(--primary);
            color: var(--white);
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }
        
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            
            .cart-table {
                font-size: 0.9rem;
            }
            
            .product-img {
                width: 60px;
                height: 60px;
            }
            
            .cart-buttons {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
                text-align: center;
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">Violet Cosmetics</div>
            <nav>
                <ul>
                    <li><a href="main.html">Home</a></li>
                    <li><a href="user_products.php">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
    <h1>Your Shopping Cart</h1>

    <?php if (empty($products)): ?>
        <p>Your cart is currently empty.</p>
        <a href="main.html" class="btn">Continue Shopping</a>
    <?php else: ?>
        <div class="cart-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($products as $product): ?>
                        <?php $subtotal = $product['price'] * $product['quantity']; ?>
                        <?php $total += $subtotal; ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['pname']) ?>" class="product-img">
                                    <div>
                                        <div class="product-name"><?= htmlspecialchars($product['pname']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= $product['quantity'] ?></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td><a href="remove_from_cart.php?id=<?= $product['product_id'] ?>" class="remove-btn">✕</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="cart-total">
                    Subtotal: <span class="total-price">$<?= number_format($total, 2) ?></span>
                </div>
                <div class="cart-buttons">
                    <a href="user_products.php" class="btn btn-secondary">Continue Shopping</a>
                    <a href="place_order.php" class="btn btn-secondary">Submit Order</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Violet Cosmetics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>