<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	
	if (isset( $_POST['Submit'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$email = htmlspecialchars($_POST['email']);

		//check if the name exists
		if(checkUsername($username)==0)
		{
			addUser($username,$password,$email);               //adds user into database
			$_SESSION['username'] = $username;
			header("Location: home.php");
		}
		else
			echo "Username is already taken taken";
	}
	
	function checkUsername($username){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
	
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

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
		$username = pg_escape_string(htmlspecialchars($username));
		$password = pg_escape_string(htmlspecialchars(sha1($password)));
		$email = pg_escape_string(htmlspecialchars($email));

		$query = "INSERT INTO spices.Users (username, password_hash, email) VALUES ($1,$2,$3)";
		pg_prepare($dbconn, "add_user_auth",$query);
	
		pg_execute($dbconn,"add_user_auth",array($username,$password, $email));
	}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>The Spice Shop - Registration</title>
    <meta name="description" content="">
    <meta name="author" content="">


</head>
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
<?php include('nav.php'); ?>
	
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

<!-- Bottom Navigation Bar -->

</body>
</html>