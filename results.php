<html>
<head>
  <title>Violet Cosmetics Search Results</title>
</head>
<body>
<h1>Violet Cosmetics Search Results</h1>
<?php
  // create short variable names
  $searchtype=$_POST['searchtype'];
  $searchterm=trim($_POST['searchterm']);

  if (!$searchtype || !$searchterm) {
     echo 'You have not entered search details.  Please go back and try again.';
     exit;
  }

  if (!get_magic_quotes_gpc()){
    $searchtype = addslashes($searchtype);
    $searchterm = addslashes($searchterm);
  }

  @ $db = new mysqli('localhost', 'deegann1_customer', 'customerpassword', 'deegann1_products');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  $query = "select * from products where ".$searchtype." like '%".$searchterm."%'";
  $result = $db->query($query);

  $num_results = $result->num_rows;

  echo "<p>Number of products found: ".$num_results."</p>";

  for ($i=0; $i <$num_results; $i++) {
     $row = $result->fetch_assoc();
     echo "<p><strong>".($i+1).". Name: ";
     echo htmlspecialchars(stripslashes($row['name']));
     echo "</strong><br />ID: ";
     echo stripslashes($row['id']);
     echo "<br />Description: ";
     echo stripslashes($row['description']);
     echo "<br />Quantity: ";
     echo stripslashes($row['quantity']);
     echo "</p>";
  }

  $result->free();
  $db->close();

?>
</body>
</html>
