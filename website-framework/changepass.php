<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";

	if(isset($_SESSION['username'])){ //if a session exists send client to home.php
	}else{
		header("Location: home.php");
	}

	
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
		$username = $_SESSION['username'];
		$getID = pg_prepare($dbconn, "getID", "SELECT user_Id FROM spices.Users where username LIKE $1");
		$getID = pg_execute($dbconn,"getID",array($username));
		$x = pg_fetch_array($getID, NULL, PGSQL_ASSOC);
		$id = $x["user_id"];


if (isset( $_POST['Submit'])){
		
		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
		$cpass = htmlspecialchars($_POST['cpass']);
		$npass = htmlspecialchars($_POST['npass']);
		$confirm = htmlspecialchars($_POST['confirm']);
		$username = $_SESSION['username'];
		$id = $x["user_id"];

		if(checkUserPass($username,$cpass)==1)
		{
			If(checkConfirm($npass,$confirm)==1){
				updatePass($npass,$id);
				$msg= "Password updated";
			}else
				$msg="Confirmation Password did not match";
		}
		else
			$msg="Incorrect Password";

	}
	

function checkUserPass($username,$password) {
		
			$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
			
			$result = pg_prepare($dbconn,"check", "SELECT password_hash FROM spices.Users WHERE username LIKE $1");
			
			$username = pg_escape_string(htmlspecialchars($username));
			$password = pg_escape_string(htmlspecialchars(sha1($password)));

			$result = pg_execute($dbconn, "check", array($username));
			$line = pg_fetch_array($result, null, PGSQL_ASSOC);
			$pass = $line['password_hash'];
			
	if($pass === $password){   
		return 1;
	}else{
		return 0;
	}
	
	}
	
function updatePass($npass,$id){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
		$password = pg_escape_string(htmlspecialchars(sha1($npass)));
		$uid = $id;

		pg_prepare($dbconn, "update", "UPDATE spices.Users SET password_hash = $1 WHERE user_id = $2");
		pg_execute($dbconn, "update",array($password, $uid));
	}
	
function checkConfirm($npass,$confirm) {
			
	if($npass === $confirm) 
		return 1;
	else
		return 0;
	
	
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Account Details</title>
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
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>
	<link rel="stylesheet" href="css/sidebar.css">


</head>
<body>
<?php include('nav.php'); ?>

<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">

          </ul>
		  <ul class="nav nav-sidebar">

          </ul>
		  <ul class="nav nav-sidebar">
            <li><a href="account.php">Account Home</a></li>
            <li><a href="orders.php">Order History</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="changepass.php">Change Password<span class="sr-only">(current)</span></a></li>
            <li><a href="addressbook.php">Address Book</a></li>
            <li><a href="payment.php">Payment Types</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Change Password</h1>
          <div class="col-md-12 column">

			<form id='address' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
			<div class="row clearfix">
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="cpass">Current Password</label><input class="form-control" name="cpass" id="cpass" type="password" required/>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="npass">New Password</label><input class="form-control" name="npass" id="npass" type="password" required/>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="confirm">Confirm Password</label><input class="form-control" name="confirm" id="confirm" type="password" required/>
					</div>
				</div>
			</div>
				<div class="row clearfix">
					<div class="col-md-6 column">
						<button type="submit" name='Submit' value='Submit' class="btn btn-default">Submit</button>
					</div>
				</div>
	      </form>
		  <h3 class="page-header"><?php echo $msg;?></h1>
		</div>
		</div>
		
    </div>
</div>

<div class="container">
	<div class="row clearfix">
		
	</div>
</div>

	<!-- Bottom Navigation Bar -->
</body>
</html>

