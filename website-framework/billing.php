<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";

	if(isset($_SESSION['username'])){ //if a session exists send client to home.php
	}else{
		header("Location: login.php");
	}

	if(isset($_POST["fname"])) {
	$_SESSION["checkout"]=array(
	'fname'=>htmlspecialchars($_POST["fname"]),
	'lname'=>htmlspecialchars($_POST["lname"]),
	'street'=>htmlspecialchars($_POST["street"]),
	'street2'=>htmlspecialchars($_POST["street2"]),
	'state_code'=>htmlspecialchars($_POST["state_code"]),
	'city'=>htmlspecialchars($_POST["city"]),
	'zip'=>htmlspecialchars($_POST["zip"])
	);
	}
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
	
	//phpinfo(INFO_VARIABLES);
	
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
			'01'=>'01',
			'02'=>'02',
			'03'=>'03',
			'04'=>'04',
			'05'=>'05',
			'06'=>'06',
			'07'=>'07',
			'08'=>'08',
			'09'=>'09',
			'10'=>'10',
			'11'=>'11',
			'12'=>'12',
            );
		
		$username = $_SESSION['username'];
		$getID = pg_prepare($dbconn, "getID", "SELECT user_Id FROM spices.Users where username LIKE $1");
		$getID = pg_execute($dbconn,"getID",array($username));
		$x = pg_fetch_array($getID, NULL, PGSQL_ASSOC);
		$id = $x["user_id"];
		
		$getArray = pg_prepare($dbconn, "getArray", "SELECT * FROM spices.cards where user_id = $1");
		$getArray = pg_execute($dbconn,"getArray",array($id));


if (isset( $_POST['Submit'])){
		
		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
		$fname = htmlspecialchars($_POST['firstName']);
		$lname = htmlspecialchars($_POST['lastName']);
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
			$msg="Card already exists";

	}
	
function checkCard($cardNumber){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
	
		$cardNumber = pg_escape_string(htmlspecialchars($cardNumber));
		
		$result = pg_prepare($dbconn, "check_card","SELECT * FROM spices.cards WHERE cardNumber like $1");
		$result = pg_execute($dbconn,"check_card",array($cardNumber));
		if(pg_num_rows($result)==0)
			return 0;
		else
			return 1;
	}
	
function addCard($name,$cardNumber,$cardType,$expMonth,$expYear,$securityCode,$id){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
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
</head>
<body>
<?php include('nav.php'); ?>
	

	<div class="container">
		<h3>Select Payment Method</h1>
			<?php while ($y = pg_fetch_array($getArray, NULL, PGSQL_ASSOC)){
								?>
	<div class="row clearfix">
		<div class="col-md-12 column">

			
			<div class="row clearfix">
				<div class="col-md-4 column">
					<form action="checkout.php" method='post'>
						<?php
								echo "<hr>";
                                echo "<strong>Owner: </strong>".$y["cardowner"];
								echo "<br>";
								echo "<strong>Card ending in: </strong>".substr($y["cardnumber"], -4 );
								echo "<br>";
								echo "<strong>Expires: </strong>".$y["expmonth"] . "/" .  $y["expyear"] . "  " . $y["zip"] ;
								echo "<br>";
								echo "<button type=\"submit\" name=\"Select\" value=\"Select\"class=\"btn btn-default\">Select</button>";
								echo '<input type="hidden" name="cardNumber" value="'.$y['cardnumber'].'">';
								echo '<input type="hidden" name="cardOwner" value="'.$y['cardowner'].'">';
								echo '<input type="hidden" name="expMonth" value="'.$y['expmonth'].'">';
								echo '<input type="hidden" name="expYear" value="'.$y['expyear'].'">';
								echo "</hr>";
								echo "</hr>";
								echo "</form>";
						?>
				</div>
		</div><?php
								}?>	
			<h3 class="page-header">Enter New Payment Method</h1>
			<form id='address' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
			<div class="row clearfix">
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="fname">First Name</label><input class="form-control" name="firstName" id="firstName" type="text" required/>
					</div>
				</div>
				<div class="col-md-6 column">
					<div class="form-group">
						<label for="lname">Last Name</label><input class="form-control" name="lastName" id="lastName" type="text" required/>
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
						<label for="securityCode">Security Code</label><input class="form-control" id="securityCode" name="securityCode" type="text" pattern="[0-9]{3}"  title="3 characters" required/>
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


	<!-- Bottom Navigation Bar -->

</body>
</html>