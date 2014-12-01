<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";

	if(isset($_SESSION['username'])){ //if a session exists send client to home.php
	}else{
		header("Location: home.php");
	}

	
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
	$cardType = array (
			'Visa'=>'Visa',
			'Mastercard'=>'Mastercard',
			'Discover'=>'Discover',
			'Amex'=>'American Express',
            );
			
	$year = array (
			'2014'=>'2014',
			'2015'=>'2015',
			'2016'=>'2016',
			'2017'=>'2017',
			'2018'=>'2018',
            );
			
	$month = array (
			'01'=>'Jan',
			'02'=>'Feb',
			'03'=>'Mar',
			'04'=>'Apr',
			'05'=>'May',
			'06'=>'Jun',
			'07'=>'Jul',
			'08'=>'Aug',
			'09'=>'Sep',
			'10'=>'Oct',
			'11'=>'Nov',
			'12'=>'Dec',
            );
		
		$username = $_SESSION['username'];
		$getID = pg_prepare($dbconn, "getID", "SELECT user_Id FROM spices.Users where username LIKE $1");
		$getID = pg_execute($dbconn,"getID",array($username));
		$x = pg_fetch_array($getID, NULL, PGSQL_ASSOC);
		$id = $x["user_id"];
		
		$getArray = pg_prepare($dbconn, "getArray", "SELECT * FROM spices.cards where user_id = $1");
		$getArray = pg_execute($dbconn,"getArray",array($id));


if (isset( $_POST['Submit'])){
		
		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$fname = htmlspecialchars($_POST['fname']);
		$lname = htmlspecialchars($_POST['lname']);
		$cardNumber = htmlspecialchars($_POST['cardNumber']);
		$cardType = htmlspecialchars($_POST['cardType']);
		$expMonth = htmlspecialchars($_POST['expMonth']);
		$expYear = htmlspecialchars($_POST['expYear']);
		$securityCode = htmlspecialchars($_POST['securityCode']);
		
		$name = $fname . ' ' . $lname;
		
		
		if(checkCard($cardNumber)==0)
		{
			addCard($name,$cardNumber,$cardType,$expMonth,$expYear,$securityCode,$id);
			header("Location:" . $_SERVER["REQUEST_URI"]);
		}
		else
			$msg="Address already exists";
	}
	
if (isset( $_POST['Delete'])){
		
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
	$index_id = htmlspecialchars($_POST['id']);
	
	pg_prepare($dbconn, "del_card","DELETE FROM spices.cards WHERE cardNumber = $1");
	pg_execute($dbconn, "del_card",array($index_id));
	
	header("Location:" . $_SERVER["REQUEST_URI"]);

	}
	
function checkCard($cardNumber){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
		$cardNumber = pg_escape_string(htmlspecialchars($cardNumber));
		
		$result = pg_prepare($dbconn, "check_card","SELECT * FROM spices.cards WHERE cardNumber like $1");
		$result = pg_execute($dbconn,"check_card",array($cardNumber));
		if(pg_num_rows($result)==0)
			return 0;
		else
			return 1;
	}
	
function addCard($name,$cardNumber,$cardType,$expMonth,$expYear,$securityCode,$id){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$user_id = pg_escape_string(htmlspecialchars($id));
		$cardNumber = pg_escape_string(htmlspecialchars($cardNumber));
		$cardType = pg_escape_string(htmlspecialchars($cardType));
		$name = pg_escape_string(htmlspecialchars($name));
		$expMonth = pg_escape_string(htmlspecialchars($expMonth));
		$expYear = pg_escape_string(htmlspecialchars($expYear));
		$securityCode = pg_escape_string(htmlspecialchars($securityCode));	

		pg_prepare($dbconn, "add_cards", "INSERT INTO spices.cards (cardOwner, cardNumber, cardType, expMonth, expYear, securityNo, user_id) VALUES ($1,$2,$3,$4,$5,$6,$7)");
		pg_execute($dbconn, "add_cards",array($name, $cardNumber, $cardType, $expMonth, $expYear, $securityCode, $user_id));
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
		#set-width{
			width: 800px;
		}
	</style>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>
	<link rel="stylesheet" href="css/sidebar.css">
	</style>

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
	        <li><a href="about_us.php">About Us</a></li>
			<!-- Redirect to Login page-->
	        <li><a href= <?=$href_page?> ><?=$log_display ?></a></li>
	      </ul>
	      <form class="navbar-form navbar-right" action="search.php" method="post">
	        <div class="form-group">
	          <input type="text" class="form-control" name="search" placeholder="Enter Search Term">
	        </div>
	        <button type="submit" class="btn btn-default">Search</button>
	      </form>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">

          </ul>
		  <ul class="nav nav-sidebar">

          </ul>
		  <ul class="nav nav-sidebar">
            <li><a href="account.php">Account Home</a></li>
            <li><a href="about_us.php">Order History</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="changepass.php">Change Password</a></li>
            <li><a href="addressbook.php">Address Book</a></li>
            <li class="active"><a href="">Payment Types<span class="sr-only">(current)</span></a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Payment Types</h1>
<div id="set-width">
	<?php while ($y = pg_fetch_array($getArray, NULL, PGSQL_ASSOC)){ ?>
	<div class="row clearfix">
		<div class="col-md-12 column">

			
			<div class="row clearfix">
				<div class="col-md-4 column">
					<form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
						<?php
								echo "<hr>";
                                echo "<strong>Owner: </strong>".$y["cardowner"];
								echo "<br>";
								echo "<strong>Card ending in: </strong>".substr($y["cardnumber"], -4 );
								echo "<br>";
								echo "<strong>Expires: </strong>".$y["expmonth"] . "/" .  $y["expyear"] . "  " . $y["zip"] ;
								echo "<br>";
								echo "<button type=\"submit\" name=\"Delete\" value=\"Delete\"class=\"btn btn-default\">Delete</button>";
								echo '<input type="hidden" name="id" value="'.$y['cardnumber'].'">';
								echo "</hr>";
								echo "</form>";
						?>
				</div>
		</div><?php
								}?>	
								<br>
			<h3 class="page-header">Enter New Payment Method</h1>
			<form id='address' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
			<div class="row clearfix">
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="fname">First Name</label><input class="form-control" name="fname" id="fname" type="text" required/>
					</div>
				</div>
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="lname">Last Name</label><input class="form-control" name="lname" id="lname" type="text" required/>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="cardNumber">Card Number</label><input class="form-control" name="cardNumber" id="cardNumber" type="text" required/>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-2 column">
					<div class="form-group">
						<label for="cardType">Card Type</label><select  class="form-control" name="cardType">
								<option value="">Select</option>
								<?php
									foreach($cardType as $key => $value):
									echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
									endforeach;
									?>
							</select>
					</div>
				</div>
				<div class="col-md-2 column">
					<div class="form-group">
						<label for="expMonth">Exp Month</label><select  class="form-control" name="expMonth">
								<option value="">Select</option>
								<?php
									foreach($month as $key2 => $value2):
									echo '<option value="'.$key2.'">'.$value2.'</option>'; //close your tags!!
									endforeach;
									?>
							</select>
					</div>
				</div>
				<div class="col-md-2 column">
					<div class="form-group">
						<label for="expYear">Exp Year</label><select  class="form-control" name="expYear">
								<option value="">Select</option>
								<?php
									foreach($year as $key2 => $value2):
									echo '<option value="'.$key2.'">'.$value2.'</option>'; //close your tags!!
									endforeach;
									?>
							</select>
					</div>
				</div>
				<div class="col-md-2 column">
					<div class="form-group">
						<label for="securityCode">Security Code</label><input class="form-control" id="securityCode" name="securityCode" type="number"  pattern=".{3,3}" required title="3 characters" required/>
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
    </div>
</div>



	<!-- Bottom Navigation Bar -->
</body>
</html>

