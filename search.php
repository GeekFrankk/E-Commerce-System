<?php
  $searchtype = $_POST['searchtype'];
  $searchterm = trim($_POST['searchterm']);

  if (!$searchtype || !$searchterm) {
     echo '<div class="container"><p>You have not entered search details. Please go back and try again.</p></div>';
     exit;
  }

  if (!get_magic_quotes_gpc()){
    $searchtype = addslashes($searchtype);
    $searchterm = addslashes($searchterm);
  }

  @ $db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');

  if (mysqli_connect_errno()) {
     echo '<div class="container"><p>Error: Could not connect to database. Please try again later.</p></div>';
     exit;
  }

  $query = "SELECT * FROM products WHERE ".$searchtype." LIKE '%".$searchterm."%'";
  $result = $db->query($query);

  $num_results = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Violet Cosmetics Search Results</title>
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

    body {
        background-color: var(--light-gray);
        color: var(--dark-gray);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    h1 {
        color: var(--primary);
        margin-bottom: 20px;
        text-align: center;
    }

    .results-count {
        font-size: 1.2rem;
        margin-bottom: 20px;
        text-align: center;
    }

    .product-card {
        background-color: var(--white);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product-card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        max-width: 150px;
        border-radius: 8px;
    }

    .product-card .product-info {
        flex: 1;
        padding-left: 20px;
    }

    .product-card strong {
        font-size: 1.3rem;
        color: var(--primary-dark);
    }

    .product-card p {
        margin: 8px 0;
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

<div class="container">
  <h1>Violet Cosmetics Search Results</h1>
  <p class="results-count">Number of products found: <?php echo $num_results; ?></p>

  <?php
    if ($num_results > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['name']) . '">';
            echo '<div class="product-info">';
            echo '<strong>' . htmlspecialchars($row['pname']) . '</strong>';
            echo '<p><strong>Price:</strong> $' . number_format($row['price'], 2) . '</p>';
            echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
            echo '<p><strong>Stock:</strong> ' . htmlspecialchars($row['stock_quantity']) . ' available</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found for your search criteria.</p>';
    }

    $result->free();
    $db->close();
  ?>
</div>

<footer>
  &copy; <?php echo date('Y'); ?> Violet Cosmetics. All rights reserved.
</footer>

</body>
</html>