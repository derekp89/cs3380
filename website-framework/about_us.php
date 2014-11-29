<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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
	
	<div id="body_wrapper">
		<div id="Title">
			<h1>About Us</h1>
		</div>
		
		<div id="about-wrapper">
			<p>We are a group composed of 6 members who got together through our database class at the University of Missouri. In this class is where we learned most of the skills we used to utilize databases in websites we can create. All of the team members worked together in writing the sql to create the database for The Spice Shop. The team members are as followed:<br></p>

			<p><b>Adam Hitchens:</b> (add something about yourself). Adam's main responsibilities for the project was designing the checkout pages.</p>
			<p><b>Andrew Pistole:</b> (add something about yourself). Andrew was in charge of the coding calls to the database for the various categories we have.</p>
			<p><b>Derek Phillips:</b> (add something about yourself). Derek developed the shopping cart and coding calls for checkout and assisted anyone if they were having issues. He also managed and supported the group as team leader, making sure everything was completed and came together.</p>
			<p><b>Morgan Hutton:</b> (add something about yourself). Morgan's job included creating the coding calls to the database for the alphabetical queries.</p>
			<p><b>Richard Elledge:</b> A Junior majoring in Information Technology at The University of Missouri. Richard was resposible for the main page and the about us page of the website.</p>
			<p><b>Yihua Shi:</b> (add something about yourself). Yihua designed the pages that displayed the database calls for the spices and categories.</p>
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
