<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>The Spice Shop - Registration</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">


</head>
	<style>
		body { padding-bottom: 70px; }
		#body_wrapper{
			width: 1000px;
			padding: auto;
			margin: auto;
		}
		/*#myCarousel{
			width: 700px;
			float:left;
		}
		#search-by-tabs{
			display:inline;
			float:left;
			margin-left:10px;
		}*/
		.alpha-highlight{
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
		/* Will create two dynamic tabs */
		$(function() {
			$( "#search-by-tabs,#tabs-1" ).tabs();
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
				$(this).addClass("alpha-highlight");
				$("li").not(this).removeClass("alpha-highlight");
			});
		});
	</script>
</head>
<body>
	<!-- Top Navigation Bar -->
	<nav class="navbar navbar-inverse" role="navigation">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Home</a>
	    </div>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
			 <!-- Drop down menu for user to choose search by alphabet or by category -->
  	        <li class="dropdown">
  	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Shop For Spices <span class="caret"></span></a>
  	          <ul class="dropdown-menu" role="menu">
  	            <li><a href="#">By Alphabet</a></li>
				<li class="divider"></li>
  	            <li><a href="#">By Category</a></li>
  	          </ul>
  	        </li>
	        <li><a href="#">View Cart</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
			<!-- Redirect to About Us page -->
	        <li><a href="#">About Us</a></li>
			<!-- Redirect to Login page-->
	        <li><a href="http://babbage.cs.missouri.edu/~cs3380f14grp13/cs3380/website-framework/login.php">Log Into Your Account</a></li>
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
<br><br><br><br>
<div class="container-fluid">
    <section class="container">
		<div class="container-page">				
			<div class="col-md-6">
				<h3 class="dark-grey">Registration</h3>
				<form id='register' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
				
				<div class="form-group col-lg-12">
					<label>Username</label>
					<input type="text" name="username" class="form-control" id="username" value="" required>
				</div>
				
				<div class="form-group col-lg-6">
					<label>Password</label>
					<input type="password" name="password" class="form-control" id="password" value="" required>
				</div>
								
				<div class="form-group col-lg-6">
					<label>Email Address</label>
					<input type="email" name="email" class="form-control" id="email" value="" required>
				</div>		
				
			
			</div>
		
			<div class="col-md-6">
				<h3 class="dark-grey">Terms and Conditions</h3>
				<p>
					By clicking on "Register" you agree to The Company's' Terms and Conditions
				</p>
				<p>
					While rare, prices are subject to change based on exchange rate fluctuations - 
					should such a fluctuation happen, we may request an additional payment. You have the option to request a full refund or to pay the new price.
				</p>
				<p>
					Should there be an error in the description or pricing of a product, we will provide you with a full refund.
				</p>
				<p>
					Acceptance of an order by us is dependent on our suppliers ability to provide the product.
				</p>
				
				<button class="btn btn-primary" type="Submit" name='Submit' value='Submit'>Register</button>
			</div>
			</form>
		</div>
	</section>
</div>

<?php
	session_start();
	
	if (isset( $_POST['Submit'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$email = htmlspecialchars($_POST['email']);

		//check if the name exists
		if(checkUsername($username)==0)
		{
			addUser($username,$password,$email);               //adds user into database
			$_SESSION['username'] = $username;
			header("Location: mycategory.html");
		}
		else
			echo "Username is already taken taken";
	}
	
	function checkUsername($username){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
		$username = pg_escape_string(htmlspecialchars($username));
		$query = "SELECT * FROM spices.Users where username LIKE $1";
		pg_prepare($dbconn, "check_u_name",$query);
		$result = pg_execute($dbconn,"check_u_name",array($username));
		if(pg_num_rows($result)==0)
			return 0;
		else
			return 1;
	}

	function addUser($username,$password, $email){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$username = pg_escape_string(htmlspecialchars($username));
		$password = pg_escape_string(htmlspecialchars(sha1($password)));
		$email = pg_escape_string(htmlspecialchars($email));

		$query = "INSERT INTO spices.Users (username, password_hash, email) VALUES ($1,$2,$3)";
		pg_prepare($dbconn, "add_user_auth",$query);
	
		pg_execute($dbconn,"add_user_auth",array($username,$password, $email));
	}

?>

<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
	      <ul class="nav navbar-nav navbar-right">
			<!-- Redirect to About Us page -->
	        <li><a href="http://babbage.cs.missouri.edu/~cs3380f14grp13/cs3380/website-framework/logout.php">Logout</a></li>
		</ul>
	  </div>
	</nav>
</body>
</html>