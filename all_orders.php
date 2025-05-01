<?php
@ $db = new mysqli("localhost", "deegann1_AllUser", "AllUserPassword", "deegann1_project");

$sql = "SELECT orders.order_id, orders.order_date, orders.order_amount, orders.status, users.fname, users.lname
        FROM orders
        JOIN users ON orders.user_id = users.id
        ORDER BY orders.order_date ASC";

$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Violet Cosmetics</title>
    <style>
        :root {
            --primary: #956aad;
            --primary-dark: #7a559a;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #333333;
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
        }
        
        .card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin: 30px 0;
        }
        
        h1 {
            color: var(--primary);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .admin-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .btn {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        th {
            background-color: var(--primary);
            color: var(--white);
        }
        
        button {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }
        
        footer {
            background-color: var(--primary);
            color: var(--white);
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">Violet Cosmetics</div>
            <nav>
                <ul>
                    <li><a href="owner_main.html">Owner Home</a></li>
                    <li><a href="all_orders.php">Orders</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <h1>Order Management</h1>
                    
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['order_id']) ?></td>
                                <td><?= htmlspecialchars($row['userId']) ?></td>
                                <td><?= htmlspecialchars($row['order_date']) ?></td>
                                <td>$<?= number_format($row['order_amount'], 2) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><?= htmlspecialchars($row['fname']) ?></td>
                                <td><?= htmlspecialchars($row['lname']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        
            <?php $db->close(); ?>

        </section>
    </main>
       
    <footer>
        <div class="container">
            <p>&copy; 2025 Violet Cosmetics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>