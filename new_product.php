<html>
<head bgcolor="#956aad">
  <title>Violet Cosmetics Entry Results</title>
</head>
<body bgcolor="#956aad">
<h1>Violet Cosmetics Entry Results</h1>
<?php
  // Get input data from POST
  $pname = $_POST['pname'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  $stock_quantity = $_POST['stock_quantity'];
  $description = $_POST['description'];
  $image_path = $_POST['image_path'];

  // Check for empty inputs
  if (!$pname || !$price || !$category || !$stock_quantity || !$description || !$image_path) {
     echo "You have not entered all the required details.<br />"
          ."Please go back and try again.";
     exit;
  }

  // Validate that price and stock_quantity are numbers
  if (!is_numeric($price) || !is_numeric($stock_quantity)) {
      echo "Price and stock quantity must be numeric values.<br />";
      exit;
  }

  // Escape inputs for security (if necessary)
  if (!get_magic_quotes_gpc()) {
    $pname = addslashes($pname);
    $category = addslashes($category);
    $description = addslashes($description);
    $image_path = addslashes($image_path);
  }

  // Establish a secure connection to the database
  $db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');

  if ($db->connect_error) {
     echo "Error: Could not connect to database. Please try again later.";
     exit;
  }

  // Prepare and bind statement to prevent SQL injection
  $stmt = $db->prepare("INSERT INTO products (pname, price, category, stock_quantity, description, image_path) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sdssis", $pname, $price, $category, $stock_quantity, $description, $image_path);

  // Execute the prepared statement
  if ($stmt->execute()) {
      echo $stmt->affected_rows . " product inserted into the database.";
  } else {
      echo "An error has occurred. The product was not added.";
  }

  // Close the statement and connection
  $stmt->close();
  $db->close();
?>
</body>
</html>



