<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	//phpinfo(INFO_VARIABLES);>
	
	if(isset($_SESSION['username'])){ //if a session exists send client to home.php
	}else{
		header("Location: login.php");
	}
	
	if(isset($_POST["fname"])){
	$_SESSION["checkout"]=array('cardOwner'=>htmlspecialchars($_POST["cardOwner"]), 'cardNumber'=>htmlspecialchars($_POST["cardNumber"]), 'expMonth'=>htmlspecialchars($_POST["expMonth"]), 'expYear'=>htmlspecialchars($_POST["expYear"]),
	'fname'=>htmlspecialchars($_POST["fname"]),
	'lname'=>htmlspecialchars($_POST["lname"]),
	'street'=>htmlspecialchars($_POST["street"]),
	'street2'=>htmlspecialchars($_POST["street2"]),
	'state_code'=>htmlspecialchars($_POST["state_code"]),
	'city'=>htmlspecialchars($_POST["city"]),
	'zip'=>htmlspecialchars($_POST["zip"])
	);
	}
	
	
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
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
	

		
	<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">

			<?php
			$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die('Could not connect:'.pg_last_error());
			 foreach ($_SESSION["products"] as $cart_itm)
        {
			$product_id = $cart_itm["id"];
			$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name, price, descr,size FROM Spices.spices WHERE id = $1 LIMIT 1');
			$result = pg_execute($dbconn, "search_by_alpha", array($product_id));
			$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			
	
echo "		<div class=\"col-xs-8\">\n";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
echo "				<div class=\"panel-body\">\n";
echo "					<div class=\"row\">\n";
echo "						<div class=\"col-xs-2\"><img class=\"img-responsive\" style=\"width:60%;height:60%\"src=\"bigpic/".$cart_itm["id"].".png\">\n";
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
echo "								<h6><strong>".$cart_itm["qty"]."</strong></h6>\n";
echo "							</div>\n";
echo "							<div class=\"col-xs-2\">\n";
echo '								<a class="glyphicon glyphicon-trash" href="spice.php?removep='.$cart_itm["id"].'&return_url='.$current_url.'"></a>';
echo "							</div>\n";
echo "						</div>\n";
echo "					</div>\n";

			$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
            $total = ($total + $subtotal);
            echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$line['name'].'" />';
            echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$line['id'].'" />';
            echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$line['descr'].'" />';
            echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
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
echo "				<div class=\"panel-footer\">\n";
echo "					<div class=\"row text-center\">\n";
echo "						<div class=\"col-xs-9\">\n";
setlocale(LC_MONETARY, 'en_US');
echo "							<h4 class=\"text-right\">Total <strong>$" .number_format($total, 2) ."</strong></h4>\n";
echo "						</div>\n";
echo "						<div class=\"col-xs-3\">\n";
echo "							<button type=\"button\" class=\"btn btn-success btn-block\">\n";
echo "								Checkout\n";
echo "							</button>\n";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
echo "			</div>\n";       
echo "		</div>\n";
echo "	</div>\n";
?>
			<div class="row clearfix">
				<div class="col-md-4 column">
						<?php
								echo "<hr>";
                                echo "<strong>Owner: </strong>".htmlspecialchars($_SESSION["checkout"]["cardOwner"]);
								echo "<br>";
								echo "<strong>Card ending in: </strong>". htmlspecialchars(substr($_SESSION["checkout"]["cardNumber"], -4 ));
								echo "<br>";
								echo "<strong>Expires: </strong>".htmlspecialchars($_SESSION["checkout"]["expMonth"]) . "/" .  htmlspecialchars($_SESSION["checkout"]["expYear"]);
								echo "</hr>";
						?>
				</div>
				<div class="col-md-4 column">
						<?php
								
								echo "<hr>";
                                echo htmlspecialchars($_SESSION["checkout"]["fname"] ). " " .  htmlspecialchars($_SESSION["checkout"]["lname"]);
								echo "<br>";
								echo htmlspecialchars($_SESSION["checkout"]["street"]) . " " .  htmlspecialchars($_SESSION["checkout"]["street2"]);
								echo "<br>";
								echo htmlspecialchars($_SESSION["checkout"]["city"]) . ", " .  htmlspecialchars($_SESSION["checkout"]["state_code"]) . "  " . htmlspecialchars($_SESSION["checkout"]["zip"] );
								echo "</hr>";
								

						?>
				</div>
		</div>
	</div>
</div>


	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>