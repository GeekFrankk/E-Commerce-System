<html>
<head bgcolor="#956aad">
  <title>Violet Cosmetics Entry Results</title>
</head>
<body bgcolor="#956aad">
<h1>Violet Cosmetics Entry Results</h1>
<?php
  // create short variable names
  $id=$_POST['id'];
  $name=$_POST['name'];
  $description=$_POST['description'];
  $quantity=$_POST['quantity'];

  if (!$id || !$name || !$description || !$quantity) {
     echo "You have not entered all the required details.<br />"
          ."Please go back and try again.";
     exit;
  }

  if (!get_magic_quotes_gpc()) {
    $id = addslashes($id);
    $name = addslashes($name);
    $description = addslashes($description);
    $quantity = doubleval($quantity);
  }

  @ $db = new mysqli('localhost', 'deegann1_customer', 'customerpassword', 'deegann1_products');

  if (mysqli_connect_errno()) {
     echo "Error: Could not connect to database.  Please try again later.";
     exit;
  }

  $query = "insert into products values
            ('".$id."', '".$name."', '".$description."', '".$quantity."')";
  $result = $db->query($query);

  if ($result) {
      echo  $db->affected_rows." product inserted into database.";
  } else {
  	  echo "An error has occurred.  The product was not added.";
  }

  $db->close();
?>
</body>
</html>
