<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	
	if (isset( $_POST['Submit'])){
		$name = htmlspecialchars($_POST['name']);
		$street = htmlspecialchars($_POST['street']);
		$city = htmlspecialchars($_POST['city']);
		$state_code = htmlspecialchars($_POST['state_code']);
		$zip = htmlspecialchars($_POST['zip']);
		
		addShipping($name,$street,$city,$state_code,$zip);              

	}
	function addShipping($name,$street,$city,$state_code,$zip){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$name = pg_escape_string(htmlspecialchars($name));
		$street = pg_escape_string(htmlspecialchars($street));
		$city = pg_escape_string(htmlspecialchars($city));
		$state_code = pg_escape_string(htmlspecialchars(sha1($state_code)));
		$zip= pg_escape_string(htmlspecialchars($zip));
		
		$query = "INSERT INTO spices.	Shipping (name, street, city, state_code, zip) VALUES ($1,$2,$3,$4,$5)";
		pg_prepare($dbconn, "add_user_auth",$query);
	
		pg_execute($dbconn,"add_user_auth",array($name,$street,$city,$state_code,$zip));
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Shipping Information</title>
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
		<h2 class="text-center">Shipping Information</h2>
		<form  action="checkout.php">
			<div >
				<label for="field1">Name</label>
				<input size="50" type="text" name="name">		
			</div>	
			<div class="form">	
				<label for="street">Street Address </label>
				<input type="text" name="street">	
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
			</div>			
			<div>
				<label for="city">City</label>
				<input type="text" name="city">					
			</div>
			<div class="form">
				<label for="state_code">State</label>	
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				
				<select name="state_code" class="form">
				<option value="AL">AL</option>
				<option value="AK">AK</option>
				<option value="AZ">AZ</option>
				<option value="AR">AR</option>
				<option value="CA">CA</option>
				<option value="CO">CO</option>
				<option value="CT">CT</option>
				<option value="DE">DE</option>
				<option value="DC">DC</option>
				<option value="FL">FL</option>
				<option value="GA">GA</option>
				<option value="HI">HI</option>
				<option value="ID">ID</option>
				<option value="IL">IL</option>
				<option value="IN">IN</option>
				<option value="IA">IA</option>
				<option value="KS">KS</option>
				<option value="KY">KY</option>
				<option value="LA">LA</option>
				<option value="ME">ME</option>
				<option value="MD">MD</option>
				<option value="MA">MA</option>
				<option value="MI">MI</option>
				<option value="MN">MN</option>
				<option value="MS">MS</option>
				<option value="MO">MO</option>
				<option value="MT">MT</option>
				<option value="NE">NE</option>
				<option value="NV">NV</option>
				<option value="NH">NH</option>
				<option value="NJ">NJ</option>
				<option value="NM">NM</option>
				<option value="NY">NY</option>
				<option value="NC">NC</option>
				<option value="ND">ND</option>
				<option value="OH">OH</option>
				<option value="OK">OK</option>
				<option value="OR">OR</option>
				<option value="PA">PA</option>
				<option value="RI">RI</option>
				<option value="SC">SC</option>
				<option value="SD">SD</option>
				<option value="TN">TN</option>
				<option value="TX">TX</option>
				<option value="UT">UT</option>
				<option value="VT">VT</option>
				<option value="VA">VA</option>
				<option value="WA">WA</option>
				<option value="WV">WV</option>
				<option value="WI">WI</option>
				<option value="WY">WY</option>
				</select>	
				
			</div>
			
			<div>				
				<label for="zip">Zip Code</label>				
				<input type="text" name="zip">		
			
			</div>	
			</br>
			</br>	
		
			<input class="btn btn-lg btn-primary btn-block" type="submit" value="Proceed to Checkout">	
		</form>
	</div>

	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>