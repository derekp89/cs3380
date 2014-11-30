<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	
	if (isset( $_POST['Submit'])){
		$fname = htmlspecialchars($_POST['fname']);
		$lname = htmlspecialchars($_POST['lname']);
		$cardType = htmlspecialchars($_POST['cardType']);
		$cardNumber = htmlspecialchars($_POST['cardNumber']);
		$expMonth = htmlspecialchars($_POST['expMonth']);
		$expYear= htmlspecialchars($_POST['expYear']);
		
		addBilling($fname,$lname,$cardType,$cardNumber,$expMonth,$expYear);              

	}
	function addBilling($fname,$lname,$cardType,$cardNumber,$expMonth,$expYear){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$fname = pg_escape_string(htmlspecialchars($fname));
		$lname = pg_escape_string(htmlspecialchars($lname));
		$cardType = pg_escape_string(htmlspecialchars($cardType));
		$cardNumber = pg_escape_string(htmlspecialchars(sha1($cardNumber)));
		$expMonth = pg_escape_string(htmlspecialchars($expMonth));
		$expYear = pg_escape_string(htmlspecialchars($expYear));
		
		$query = "INSERT INTO spices.	Cards (fname, lname, cardType, cardNumber_hash, expMonth, expYear) VALUES ($1,$2,$3,$4,$5,$6)";
		pg_prepare($dbconn, "add_user_auth",$query);
	
		pg_execute($dbconn,"add_user_auth",array($fname,$lname,$cardType,$cardNumber,$expMonth,$expYear));
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Billing Information</title>
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
		
		.content
		{
			width 49%;
			float: left;
			overflow: hidden;/* Makes this div contain its floats */
		}
		
		.content label {
		display: block;
		}
		
		.form
		{
			float: left;
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
	        <li><a href= login.php >Log Into Your Account</a></li>
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
	

	<div class="col-sm-6 col-md-4 col-md-offset-4 content">	
		<h2 class="text-center">Billing Information</h2>
		<form action="shipping.php">
			<div >
					<label for="field1">Name on Card</label>
					<input type="text" name="cardOwner">
			
			</div>	
			</br>
			<div>	
				<div>
					<label for="field1">Card Type</label>
					
						<select name="cards">
						<option value="visa">Visa</option>
						<option value="mastercard">Mastercard</option>
						<option value="discover">Discover</option>
						<option value="american_express">American Express</option>
						</select>
					
				</div>
				</br>
				<div>
					<label for="cardNumber">Credit Card Number</label>
					<input	 type="text" name="cardNumber">
				</div>
			</div>
			</br>
			<div>	
				<div>
					<label for="expMonth">Expiration Date</label>
					
					
						<select name="expMonth" class="form">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						</select>
									
						<select name="expYear" class="form">
						<option>2014</option>
						<option>2015</option>
						<option>2016</option>
						<option>2017</option>
						<option>2018</option>
						<option>2019</option>
						<option>2020</option>
						<option>2021</option>
						<option>2022</option>
						<option>2023</option>
						</select>
					
					
				</div>
			</div>	
			</br>
			</br>	
		
			<input class="btn btn-lg btn-primary btn-block" type="submit" value="Proceed to Shipping">	
		</form>
	</div>


	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>