<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>About Us</title>
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
		#image-wrap{
		
		}
		#inner {
			width: 50%;
			margin: 50px auto;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>

</head>
<body>
<?php include('nav.php'); ?>
	<div id="body_wrapper">
		<div id="Title">
			<h1>About Us</h1>
		</div>
		
		<div id="about-wrapper">
			<p>We are merchants of the highest quality, hand-selected and hand-prepared spices and herbs. Welcome to our web site, where you can browse our spices, buy gifts, learn about the history and lore of spices.<br></p>
			<div id='inner'>
				<iframe width="640" height="360" src="https://www.youtube.com/embed/okmYclmtb_o?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>

			</div>
		</div>
		
	</div>


	<!-- Bottom Navigation Bar -->
	
</body>
</html>
