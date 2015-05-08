<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	
	if(isset($_SESSION['username'])){ //if a session exists send client to home.php

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
            <li class="active"><a href="account.php">Account Home<span class="sr-only">(current)</span></a></li>
            <li><a href="orders.php">Order History</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="changepass.php">Change Password</a></li>
            <li><a href="addressbook.php">Address Book</a></li>
            <li><a href="payment.php">Payment Types</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
		  </div>
    </div>
</div>

</body>
</html>
<?php
	}else{
	header("Location: home.php");
	}?>
