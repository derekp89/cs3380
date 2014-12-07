<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";

	if(isset($_SESSION['username'])){ //if a session exists send client to home.php
	}else{
		header("Location: home.php");
	}

	
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$username = $_SESSION['username'];
		$getID = pg_prepare($dbconn, "getID", "SELECT user_Id FROM spices.Users where username LIKE $1");
		$getID = pg_execute($dbconn,"getID",array($username));
		$x = pg_fetch_array($getID, NULL, PGSQL_ASSOC);
		$id = $x["user_id"];
		
		$getArray = pg_prepare($dbconn, "getArray", "SELECT * FROM spices.orders where user_Id = $1");
		$getArray = pg_execute($dbconn,"getArray",array($id));


if (isset( $_POST['Submit'])){
		
		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$fname = htmlspecialchars($_POST['fname']);
		$lname = htmlspecialchars($_POST['lname']);
		$street = htmlspecialchars($_POST['address']);
		$street2 = htmlspecialchars($_POST['address2']);
		$city = htmlspecialchars($_POST['city']);
		$state = htmlspecialchars($_POST['state']);
		$zip = htmlspecialchars($_POST['zip']);
		
		
		if(checkAdd($street,$street2,$zip,$id)==0)
		{
			addAddress($fname,$lname,$city,$street,$street2,$zip,$state,$id);
			header("Location:" . $_SERVER["REQUEST_URI"]);
			
		}
		else
			$msg="Address already exists";
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Account Details</title>
	<style>
		body { padding-bottom: 70px; }
		#body_wrapper{
			width: 1000px;
			padding: auto;
			margin: auto;
		}
		.scale-img{
			width:1000px;
		}
		#set-width{
			width: 800px;
		}
	</style>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>
	<link rel="stylesheet" href="css/sidebar.css">
	</style>

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

<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">

          </ul>
		  <ul class="nav nav-sidebar">

          </ul>
		  <ul class="nav nav-sidebar">
            <li><a href="account.php">Account Home</a></li>
            <li class="active"><a href="orders.php">Order History</a><span class="sr-only">(current)</span></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="changepass.php">Change Password</a></li>
            <li><a href="addressbook.php">Address Book</a></li>
            <li><a href="payment.php">Payment Types</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Order History</h1>
	<?php while ($y = pg_fetch_array($getArray, NULL, PGSQL_ASSOC)){ ?>
	<div class="row clearfix">
		<div class="col-md-12 column">
			
			<div class="row clearfix">
				<div class="col-md-4 column">
					<form action="order_details.php" method='post'>
						<?php
								$getItems = pg_prepare($dbconn, "getItems", "SELECT product_id FROM spices.Order_Details where order_id = $1");
								$getItems = pg_execute($dbconn,"getItems",array($y["order_id"]));
								while ($rows = pg_fetch_array($getItems, NULL, PGSQL_ASSOC)){
										$getName = pg_prepare($dbconn, "getName", "SELECT name FROM spices.spices where id = $1");
										$getName = pg_execute($dbconn,"getName",array($rows["product_id"]));
										$name = pg_fetch_array($getName, NULL, PGSQL_ASSOC);
										$pids[]=$name['name'];
								}
								$comma_separated = implode(",&nbsp&nbsp", $pids);
								
								$getPrice = pg_prepare($dbconn, "getPrice", "SELECT SUM(price) FROM spices.Order_Details where order_id = $1");
								$getPrice = pg_execute($dbconn,"getPrice",array($y["order_id"]));
								$row = pg_fetch_array($getPrice, NULL, PGSQL_ASSOC);
								$p= $row['sum'];
								
								setlocale(LC_MONETARY, 'en_US');
								
								echo "<hr>";
                                echo '<strong><p>Date of purchase: </strong>'. substr($y["order_date"], 0, -15 ). '</p>';
								echo '<strong><p>Total: $</strong>'.number_format($p, 2).'</p>';
								echo '<strong><p>Items: </strong>'.$comma_separated.'</p>';
								echo "<button type=\"submit\" name=\"Select\" value=\"Select\"class=\"btn btn-default\">Select</button>";
								echo '<input type="hidden" name="id" value="'.$y['order_id'].'">';
								echo "</hr>";
								echo "</form>";
								unset ($pids);
						?>
				</div>
				<div class="col-md-4 column">
						<?php
							$getAddress = pg_prepare($dbconn, "getAddress", "SELECT * FROM spices.Shipping where shipping_id = $1");
							$getAddress = pg_execute($dbconn,"getAddress",array($y["order_id"]));
							$row = pg_fetch_array($getAddress, NULL, PGSQL_ASSOC);
							echo "<hr>";
							echo '<strong><p>Shipping Address</strong></p>';
							echo $row["fname"]. " " .  $row["lname"];
							echo "<br>";
							echo $row["street"] . " " .  $row["street2"];
							echo "<br>";
							echo $row["city"] . ", " .  $row["state_code"] . "  " . $row["zip"];
							echo "</div>";
							echo '<div class="col-md-4 column">';
							echo "<hr>";
							echo '<strong><p>Shipping Details</strong></p>';
							echo "<br>";
							echo "<strong><p>Tracking No: </strong>".$row['tracking_no']."</p>";
							echo "<strong><p>Courier: </strong>".$row['carrier']. "</p>";
						?>
				
				</div>
		</div><?php
								}?>	
								<br>
			
	</div>
</div>
		  </div>
    </div>
</div>


	<!-- Bottom Navigation Bar -->
</body>
</html>

