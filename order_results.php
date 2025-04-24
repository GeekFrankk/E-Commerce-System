<?php
  // create short variable names
  $tonerqty = $_POST['tonerqty'];
  $facecreamqty = $_POST['facecreamqty'];
  $sunscreenqty = $_POST['sunscreenqty'];
  $find = $_POST['find'];
?>
<html>
<head>
  <title>Violet Skincare Products - Order Result</title>
</head>
<body>
<h1>Violet Skincare Products</h1>
<h2>Order Results</h2>
<?php

	echo "<p>Order processed at ".date('H:i, jS F Y')."</p>";

	echo "<p>Your order is as follows: </p>";

	$totalqty = 0;
	$totalqty = $tonerqty + $facecreamgty + $sunscreenqty;
	echo "Items ordered: ".$totalqty."<br />";


	if ($totalqty == 0) {

	  echo "You did not order anything on the previous page!<br />";

	} else {

	  if ($tonerqty > 0) {
		echo $tonerqty." toner<br />";
	  }

	  if ($facecreamqty > 0) {
		echo $facecreamqty." face cream<br />";
	  }

	  if ($sunscreenqty > 0) {
		echo $sunscreenqty." suncreen<br />";
	  }
	}


	$totalamount = 0.00;

	define('TONERPRICE', 20);
	define('FACECREAMPRICE', 15);
	define('SUNSCREENPRICE', 10);

	$totalamount = $tonerqty * TONERPRICE
				 + $facecreamqty * FACECREAMPRICE
				 + $sunscreenqty * SUNSCREENPRICE;

	echo "Subtotal: $".number_format($totalamount,2)."<br />";

	$taxrate = 0.10;  // local sales tax is 10%
	$totalamount = $totalamount * (1 + $taxrate);
	echo "Total including tax: $".number_format($totalamount,2)."<br />";

	if($find == "a") {
	  echo "<p>Regular customer.</p>";
	} elseif($find == "b") {
	  echo "<p>Customer referred by TV advert.</p>";
	} elseif($find == "c") {
	  echo "<p>Customer referred by phone directory.</p>";
	} elseif($find == "d") {
	  echo "<p>Customer referred by word of mouth.</p>";
	} else {
	  echo "<p>We do not know how this customer found us.</p>";
	}

?>
</body>
</html>
