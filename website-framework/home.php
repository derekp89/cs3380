<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>The Spice Shop</title>
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
	</style>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>

</head>
<body>
<!-- Top Navigation Bar -->
<?php include('nav.php'); ?>
	
	<div id="body_wrapper">
		<div id="Title">
			<h1>THE SPICE SHOP</h1>
		</div>
		
		<div id="myCarousel" class="carousel slide" data-interval="3000">
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		    <li data-target="#myCarousel" data-slide-to="3"></li>
		    <li data-target="#myCarousel" data-slide-to="4"></li>
		  </ol>
	
		  <div class="carousel-inner" data-interval="3000">
		    <div class="active item"><img class="scale-img" style="height:577px;" src="https://farm4.staticflickr.com/3318/3346295578_2dcce20805_b.jpg"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="https://farm4.staticflickr.com/3221/2687570771_fc39dc2ee8_z.jpg?zz=1"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="http://www.thesleuthjournal.com/wp-content/uploads/2014/02/HealthPromotingSpices.jpg"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="http://www.thespiceguyco.com/uploads/8/9/0/8/8908117/8561362.jpg"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="http://www.getrichslowly.org/images/GRS/spices.jpg"></div>
		  </div>

		  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
		
		<div class="paragraph-wrapper">
			<p><b>Welcome to The Spice Shop!</b> This is a website where you can search for a wide variety of spices and herbs by name and catagory. You'll be able to see a description about the spices and herbs and then add the ones you want to your shopping cart and purchase them based on the amount you want.</p>
		</div>

	</div>


	<!-- Bottom Navigation Bar -->

</body>
</html>
