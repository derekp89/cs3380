<?php
session_start();
$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Browse Spices by Name, Category</title>
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
  	          <ul id="d-menu" class="dropdown-menu" role="menu">
  	            <li><a href="alpha_category.php">By Alphabet</a></li>
				<li class="divider"></li>
  	            <li><a href="alpha_category.php">By Category</a></li>
  	          </ul>
  	        </li>
	        <li><a href="#">View Cart</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
			<!-- Redirect to About Us page -->
	        <li><a href="#">About Us</a></li>
			<!-- Redirect to Login page-->
	        <li><a href= <?=$href_page?> ><?=$log_display ?></a></li>
	      </ul>
	      <form class="navbar-form navbar-right" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Enter Search Term">
	        </div>
	        <button type="submit" class="btn btn-default">Search</button>
	      </form>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	

	
<?php
    if(isset($_SESSION["products"]))
    {
		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die('Could not connect:'.pg_last_error());
		$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $total = 0;
        echo '<form method="post" action="">';
        echo '<ul>';
        $cart_items = 0;
		echo "<div class=\"container\">\n";
		echo "<div class=\"row\">\n";
        foreach ($_SESSION["products"] as $cart_itm)
        {
			$product_id = $cart_itm["id"];
			$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name, price, descr FROM Spices.spices WHERE id = $1 LIMIT 1');
			$result = pg_execute($dbconn, "search_by_alpha", array($product_id));
			$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			
	
echo "		<div class=\"col-xs-8\">\n";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
echo "				<div class=\"panel-body\">\n";
echo "					<div class=\"row\">\n";
echo "						<div class=\"col-xs-2\"><img class=\"img-responsive\" src=\"http://placehold.it/100x70\">\n";
echo "						</div>\n";
echo "						<div class=\"col-xs-4\">\n";
echo "							<h4 class=\"product-name\"><strong>".$line['name']."</strong></h4><h4><small>".$line['descr']."</small></h4>\n";
echo "						</div>\n";
echo "						<div class=\"col-xs-6\">\n";
echo "							<div class=\"col-xs-6 text-right\">\n";
echo "								<h6><strong>".$line['price']."<span class=\"text-muted\">x</span></strong></h6>\n";
echo "							</div>\n";
echo "							<div class=\"col-xs-4\">\n";
echo "								<input type=\"text\" class=\"form-control input-sm\" value=\"".$cart_itm["qty"]."\">\n";
echo "							</div>\n";
echo "							<div class=\"col-xs-2\">\n";
echo '								<a class="glyphicon glyphicon-trash" href="spice.php?removep='.$cart_itm["id"].'&return_url='.$current_url.'"></a>';
echo "							</div>\n";
echo "						</div>\n";
echo "					</div>\n";


            echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$line['name'].'" />';
            echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$line['id'].'" />';
            echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$line['descr'].'" />';
            echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
            $cart_items ++;
           
        }
		
		
echo "					<hr>\n";
echo "					<div class=\"row\">\n";
echo "						<div class=\"text-center\">\n";
echo "							<div class=\"col-xs-9\">\n";
echo "								<h6 class=\"text-right\">Added items?</h6>\n";
echo "							</div>\n";
echo "							<div class=\"col-xs-3\">\n";
echo "								<button type=\"button\" class=\"btn btn-default btn-sm btn-block\">\n";
echo "									Update cart\n";
echo "								</button>\n";
echo "							</div>\n";
echo "						</div>\n";
echo "					</div>\n";
echo "				</div>\n";
echo "				<div class=\"panel-footer\">\n";
echo "					<div class=\"row text-center\">\n";
echo "						<div class=\"col-xs-9\">\n";
			$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
            $total = ($total + $subtotal);
echo "							<h4 class=\"text-right\">Total <strong>$" .$total."</strong></h4>\n";
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
       
    }else{
        echo 'Your Cart is empty';
    }
?>


	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>