<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php"); // or wherever your login page is
    exit;
}

$userId = $_SESSION['userId'];

@ $db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');

  if (mysqli_connect_errno()) {
     die("Connection failed: " . $db->connect_error);
  }
  
$sql ="SELECT * FROM products";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violet Cosmetics</title>
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
        
        .banner {
            padding: 40px 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px;
            color: var(--primary-light);
        }
        
        .banner h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-light);
        }
        
        .banner p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            color: var(--primary);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .product-card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-img {
            height: 200px;
            width: 100%;
            position: relative;
            overflow: hidden;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            background-color: var(--primary-light);
        }
        
        .product-img img {
            width: 120%;
            height: 120%;
            object-fit: cover;
            transform: scale(1.1) rotate(-5deg);
            transition: transform 0.5s ease;
            opacity: 0.85;
            filter: saturate(1.2);
        }
        
        .product-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(149, 106, 173, 0.5) 0%, rgba(255, 156, 238, 0.2) 100%);
            z-index: 1;
        }
        
        .product-img::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 30px;
            background-color: var(--white);
            bottom: -15px;
            left: 0;
            border-radius: 50%;
        }
        
        .product-card:hover .product-img img {
            transform: rotate(0deg);
            opacity: 1;
        }

        .product-info {
            padding: 15px;
        }
        
        .product-name {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .product-price {
            color: var(--primary);
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        
        .btn {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
        }
        
        .search-bar {
            display: flex;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .search-bar input {
            flex-grow: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 25px 0 0 25px;
            font-size: 1rem;
            border-right: none;
        }
        
        .search-bar button {
            padding: 10px 20px;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 0 25px 25px 0;
            cursor: pointer;
        }
        
        .categories {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .category-btn {
            background-color: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 8px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .category-btn:hover, .category-btn.active {
            background-color: var(--primary);
            color: var(--white);
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
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .banner h1 {
                font-size: 2rem;
            }
            
            .banner p {
                font-size: 1rem;
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
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <!-- banner -->
        <section class="banner">
            <h1>Beauty Essentials</h1>
            <p>Discover premium skincare products that nourish and enhance your natural beauty</p>
        </section>

        <section class="search-section">
            <form action="search.php" method="POST" class="search-bar">
                <input type="text" name="searchterm" placeholder="Search for products...">
                <select name="searchtype">
                    <option value="pname">Name</option>
                    <option value="description">Description</option>
                    <option value="category">Category</option>
                </select>
                <button type="submit">Search</button>
            </form>
        </section>

        <!-- product display -->
        <section id="products">
            <h1>Featured Products</h1>
            <div class="product-grid">
                
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <div class="product-img">
                            <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['pname']) ?>">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?= htmlspecialchars($row['pname']) ?></h3>
                            <p><?= htmlspecialchars($row['description']) ?></p>
                            <p class="product-price">$<?= number_format($row['price'], 2) ?></p>
                            <a href="add_to_cart.php?id=<?= $row['product_id'] ?>" class="btn">Add to Cart</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Violet Cosmetics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>