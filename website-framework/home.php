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
	
	<div id="body_wrapper">
		<div id="Title">
			<h1>THE SPICE SHOP</h1>
		</div>
		
		<div id="myCarousel" class="carousel slide" data-interval="3000">
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>
	
		  <div class="carousel-inner">
		    <div class="active item"><img class="scale-img" src="https://farm6.staticflickr.com/5140/5461417415_b58a112fe1_b.jpg"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="https://farm4.staticflickr.com/3318/3346295578_2dcce20805_b.jpg"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="https://farm4.staticflickr.com/3221/2687570771_fc39dc2ee8_z.jpg?zz=1"></div>
		    <div class="item"><img class="scale-img" style="height:577px;" src="http://www.thesleuthjournal.com/wp-content/uploads/2014/02/HealthPromotingSpices.jpg"></div>
		  </div>

		  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
		
		<div class="paragraph-wrapper">
			<p><b>Welcome to The Spice Shop!</b> This is a website where you can search for a wide variety of spices and herbs by name and catagory. You'll be able to see a description about the spices and herbs and then add the ones you want to your shopping cart and purchase them based on the amount you want. The database for our spices was created by us, using different spices we found and researched. Our website is still a work in progress, and was mainly created to help develop the team's coding skills in php and sql, in addition to learning basic website layout and website development which implements the use of databases.</p>
		</div>

	</div>


	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
	      <ul class="nav navbar-nav navbar-right">
			<!-- Redirect to About Us page -->
	        <li></li>
		</ul>
	  </div>
	</nav>
</body>
</html>
