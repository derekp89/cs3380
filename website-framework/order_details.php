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
		
		$getArray = pg_prepare($dbconn, "getArray", "SELECT * FROM spices.Order_Details where order_id = $1");
		$getArray = pg_execute($dbconn,"getArray",array($_POST['id']));



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
          <h1 class="page-header">Order Details</h1>

	<div class="row clearfix">
		<div class="col-md-12 column">
			
			<div class="row clearfix">
				<div class="col-md-8 column">
						<?php
								$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die('Could not connect:'.pg_last_error());
			
			$cart_items = 0;
		while ($linex = pg_fetch_array($getArray, NULL, PGSQL_ASSOC)){	
        {
			$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name, price, descr,size FROM Spices.spices WHERE id = $1 LIMIT 1');
			$result = pg_execute($dbconn, "search_by_alpha", array($linex['product_id']));
			$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			
			
	
echo "		<div class=\"col-xs-8\">\n";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
echo "				<div class=\"panel-body\">\n";
echo "					<div class=\"row\">\n";
echo "						<div class=\"col-xs-2\"><img class=\"img-responsive\" style=\"width:60%;height:60%\"src=\"bigpic/".$linex["product_id"].".png\">\n";
echo "						</div>\n";
echo "						<div class=\"col-xs-4\">\n";
echo "							<h4 class=\"product-name\"><strong>".$line['name']."</strong></h4><h4><small>".$line['descr']."</small></h4>\n";
echo "						</div>\n";
echo "						<div class=\"col-xs-6\">\n";
echo "							<div class=\"col-xs-6 text-right\">\n";
echo "								<h6><strong>".$line['size']." oz.</strong></h6>\n";
echo "							</div>\n";
echo "						<div class=\"col-xs-6\">\n";
echo "							<div class=\"col-xs-6 text-right\">\n";
echo "								<h6><strong>$".$line['price']." &nbsp;&nbsp;&nbsp;&nbsp;x</strong></h6>\n";
echo "							</div>\n";
echo "							<div class=\"col-xs-2\">\n";
echo "								<h6><strong>".$linex["quantity"]."</strong></h6>\n";
echo "							</div>\n";
echo "						</div>\n";
echo "					</div>\n";

			$subtotal = ($linex["price"]*$linex["quantity"]);
            $total = ($total + $subtotal);
            echo '<input type="hidden" name="price" value="'.$line['price'].'" />';
            $cart_items ++;
           
        }
		
		
echo "					<hr>\n";
echo "					<div class=\"row\">\n";
echo "						<div class=\"text-center\">\n";
echo "							<div class=\"col-xs-3\">\n";
echo "							</div>\n";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
}
echo "				<div class=\"panel-footer\">\n";
echo "					<div class=\"row text-center\">\n";
echo "						<div class=\"col-xs-9\">\n";
setlocale(LC_MONETARY, 'en_US');

echo "							<h4 class=\"text-right\">Total <strong>$" .number_format($total, 2) ."</strong></h4>\n";
echo "						</div>\n";
echo "						<div class=\"col-xs-3\">\n";
echo ' <form action="orders.php">';
echo "							<button type=\"submit\" class=\"btn btn-success btn-block\">\n";
echo "								Back\n";
echo "							</button>\n";
echo " </form>";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
echo "			</div>\n";       
echo "		</div>\n";
echo "	</div>\n";
						?>
				</div>
		</div>	
								<br>
			
	</div>
</div>
		  </div>
    </div>
</div>


	<!-- Bottom Navigation Bar -->
</body>
</html>

