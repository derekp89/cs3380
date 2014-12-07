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
	<script>
		/* Will create three dynamic tabs */
		$(function() {
			$( "#search-by-tabs, #tabs-1" ).tabs();
			$( "#tabs-2" ).tabs();
			$( "#d-menu" ).tabs();
		});
		
		/* Will highlight the search-by tabs which the user clicked on */
		$(function() {
			$( "#search-by li" ).click(function(){
				$(this).addClass("active");
				$("li").not(this).removeClass("active");
			});
		});
		
		/* Will highlight the alphabet tab which the user clicked on */
		$(function() {
			$( "#tabs-1 li" ).click(function(){
				$(this).addClass("tabs-bg-highlight");
				$("#tabs-1 li").not(this).removeClass("tabs-bg-highlight");
			});
		});
		/* */
		$(function() {
			$( "#tabs-2 li" ).click(function(){
				$(this).addClass("tabs-bg-highlight");
				$("#tabs-2 li").not(this).removeClass("tabs-bg-highlight");
			});
		});
	</script>
	<script src="ajax.js"></script>
	<script>
		/* Will update the alphabet content box depending on the letter user chose to search by */
		function updateAlpha(alphaId){
			$.get("search_by_alphabet_handler.php",
			{ "alphaId": alphaId },
			function(data){
				$('#'+alphaId).html(data);
			});
		}

		/* Will update the category content box depending on the category user chose to search by */
		function updateCategory(cId){
			$.get("search_by_category_handler.php",
			{ "cId": cId },
			function(data){
				$('#'+cId).html(data);
			});
		}
		
		/* Will apply the function updateAlpha on the <li> element that the user clicked on */
		$(function(){
			$("#alpha-tabs-list li").click(
				function(){
					updateAlpha(this.textContent);
			});
		});
		
		/* Will apply the function updateCategory on the <li> element that the user clicked on */
		$(function(){
			$("#category-tabs-list li").click(
				function(){
					console.log(this.textContent);
					updateCategory(this.textContent);
			});
		});

	</script>
</head>
<body>
<!-- Top Navigation Bar -->
	<nav class="navbar navbar-inverse" role="navigation">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="home.php">Home</a>
	    </div>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
			 <!-- Drop down menu for user to choose search by alphabet or by category -->
  	        <li class="dropdown">
  	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Shop For Spices <span class="caret"></span></a>
  	          <ul class="dropdown-menu" role="menu">
  	            <li><a href="alpha_category.php">By Alphabet</a></li>
				<li class="divider"></li>
  	            <li><a href="alpha_category.php#">By Category</a></li>
  	          </ul>
  	        </li>
	        <li><a href="cart.php">View Cart</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
		  <!-- Redirect to User account page -->
		  <?php  if($_SESSION['username']){?>
			<li><a href="account.php"><?php echo ucfirst($_SESSION['username']); ?>'s Account</a></li>
			<?php } ?>
			<!-- Redirect to About Us page -->
	        <li><a href="about_us.php">About Us</a></li>
			<!-- Redirect to Login page-->
	        <li><a href= <?=$href_page?> ><?=$log_display ?></a></li>
	      </ul>
	      <form class="navbar-form navbar-right" action="search.php" method="post">
	        <div class="form-group">
	          <input type="text" class="form-control" name="search" placeholder="Enter Search Term" required>
	        </div>
	        <button type="submit" class="btn btn-default">Search</button>
	      </form>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	

	
<?php
   
   $dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die('Could not connect:'.pg_last_error());
   
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
		$p= $line['price'];
	
		$addArray = pg_prepare($dbconn, "addArray", "INSERT INTO spices.Order_Details(product_id, quantity, price, order_id)  VALUES($1,$2,$3,$4)");
		$addArray = pg_execute($dbconn,"addArray",array($cart_itm["id"], $cart_itm["qty"], $p,  $z+1)) or die('Could not connect:'.pg_last_error());
   }

   unset($_SESSION["checkout"]);
   unset($_SESSION["products"]);
   ?>
   
<h1><strong>Thanks for your purchase</h1></strong>


	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>
