<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	
	
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
  	          <ul id="d-menu" class="dropdown-menu" role="menu">
  	            <li><a href="alpha_category.php">By Alphabet</a></li>
				<li class="divider"></li>
  	            <li><a href="alpha_category.php">By Category</a></li>
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
	      <form class="navbar-form navbar-right" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Enter Search Term">
	        </div>
	        <button type="submit" class="btn btn-default">Search</button>
	      </form>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	

		
	<h2>Check Out</h2>
	<?
	
	?>

	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>