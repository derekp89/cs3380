<?php
session_start();
$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>The Spice Shop: Cart</title>
	<style>
		body { padding-bottom: 70px; }
		#body_wrapper{
			width: 1000px;
			padding: auto;
			margin: auto;
		}

		.tabs-bg-highlight{
			background-color: rgb(216, 226, 244);
		}
		.scale-img{
			width:1000px;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>
	<meta http-equiv="refresh" content="2;url=http://babbage.cs.missouri.edu/~dmpkb4/k/cs3380/website-framework/orders.php" />
</head>
<body>
<?php include('nav.php'); ?>
	

	
<?php
   
  $dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
   
   $username = $_SESSION['username'];
	$getID = pg_prepare($dbconn, "getID", "SELECT user_Id FROM spices.Users where username LIKE $1");
	$getID = pg_execute($dbconn,"getID",array($username));
	$x = pg_fetch_array($getID, NULL, PGSQL_ASSOC);
	$id = $x["user_id"];
   
	$d = pg_query($dbconn,"SELECT MAX(order_id) FROM spices.orders");
	$line = pg_fetch_array($d, NULL, PGSQL_ASSOC);
	$z= $line['max'];
	
	$addOrder = pg_prepare($dbconn, "addOrder", "INSERT INTO spices.Orders(user_id, order_id)  VALUES($1,$2)");
	$addOrder = pg_execute($dbconn,"addOrder",array($id, $z+1)) or die('Could not connect:'.pg_last_error());
   
	$addShipping = pg_prepare($dbconn, "addShipping", "INSERT INTO spices.Shipping (fname, lname, street, street2, city, state_code, zip, shipping_id, tracking_no, carrier)  VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10)");
	$addShipping = pg_execute($dbconn,"addShipping",array($_SESSION["checkout"]["fname"],
																						$_SESSION["checkout"]["lname"],
																						$_SESSION["checkout"]["street"],
																						$_SESSION["checkout"]["street2"],
																						$_SESSION["checkout"]["city"],
																						$_SESSION["checkout"]["state_code"],
																						$_SESSION["checkout"]["zip"],
																						$z+1,
																						md5($z),
																						"UPS"))
																						or die('Could not connect:'.pg_last_error());
																						
	foreach ($_SESSION["products"] as $cart_itm){
	
		$getPrice = pg_prepare($dbconn, "getPrice", "SELECT price FROM spices.spices WHERE id = $1");
		$getPrice = pg_execute($dbconn,"getPrice",array($cart_itm["id"])) or die('Could not connect:'.pg_last_error());
		$line = pg_fetch_array($getPrice, NULL, PGSQL_ASSOC);
		$p= $line['price']* $cart_itm["qty"];
	
		$addArray = pg_prepare($dbconn, "addArray", "INSERT INTO spices.Order_Details(product_id, quantity, price, order_id)  VALUES($1,$2,$3,$4)");
		$addArray = pg_execute($dbconn,"addArray",array($cart_itm["id"], $cart_itm["qty"], $p,  $z+1)) or die('Could not connect:'.pg_last_error());
   }

   unset($_SESSION["checkout"]);
   unset($_SESSION["products"]);
   
 
   ?>
   
<h1><strong>Thanks for your purchase</h1></strong>


	<!-- Bottom Navigation Bar -->

</body>
</html>
