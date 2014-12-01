<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";

	if(isset($_SESSION['username'])){ //if a session exists send client to home.php
	}else{
		header("Location: home.php");
	}

	
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
	$states = array (
            'AL'=>'Alabama',
            'AK'=>'Alaska',
            'AZ'=>'Arizona',
            'AR'=>'Arkansas',
            'CA'=>'California',
            'CO'=>'Colorado',
            'CT'=>'Connecticut',
            'DE'=>'Delaware',
            'DC'=>'District Of Columbia',
            'FL'=>'Florida',
            'GA'=>'Georgia',
            'HI'=>'Hawaii',
            'ID'=>'Idaho',
            'IL'=>'Illinois',
            'IN'=>'Indiana',
            'IA'=>'Iowa',
            'KS'=>'Kansas',
            'KY'=>'Kentucky',
            'LA'=>'Louisiana',
            'ME'=>'Maine',
            'MD'=>'Maryland',
            'MA'=>'Massachusetts',
            'MI'=>'Michigan',
            'MN'=>'Minnesota',
            'MS'=>'Mississippi',
            'MO'=>'Missouri',
            'MT'=>'Montana',
            'NE'=>'Nebraska',
            'NV'=>'Nevada',
            'NH'=>'New Hampshire',
            'NJ'=>'New Jersey',
            'NM'=>'New Mexico',
            'NY'=>'New York',
            'NC'=>'North Carolina',
            'ND'=>'North Dakota',
            'OH'=>'Ohio',
            'OK'=>'Oklahoma',
            'OR'=>'Oregon',
            'PA'=>'Pennsylvania',
            'RI'=>'Rhode Island',
            'SC'=>'South Carolina',
            'SD'=>'South Dakota',
            'TN'=>'Tennessee',
            'TX'=>'Texas',
            'UT'=>'Utah',
            'VT'=>'Vermont',
            'VA'=>'Virginia',
            'WA'=>'Washington',
            'WV'=>'West Virginia',
            'WI'=>'Wisconsin',
            'WY'=>'Wyoming',);
		
		$username = $_SESSION['username'];
		$getID = pg_prepare($dbconn, "getID", "SELECT user_Id FROM spices.Users where username LIKE $1");
		$getID = pg_execute($dbconn,"getID",array($username));
		$x = pg_fetch_array($getID, NULL, PGSQL_ASSOC);
		$id = $x["user_id"];
		
		$getArray = pg_prepare($dbconn, "getArray", "SELECT * FROM spices.Address where user_Id = $1");
		$getArray = pg_execute($dbconn,"getArray",array($id));


if (isset( $_POST['Submit'])){
		
		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$fname = htmlspecialchars($_POST['fname']);
		$lname = htmlspecialchars($_POST['lname']);
		$street = htmlspecialchars($_POST['address']);
		$street2 = htmlspecialchars($_POST['address2']);
		$city = htmlspecialchars($_POST['city']);
		$state = htmlspecialchars($_POST['state']);
		$zip = htmlspecialchars($_POST['zip']);
		
		
		if(checkAdd($street,$street2,$zip,$id)==0)
		{
			addAddress($fname,$lname,$city,$street,$street2,$zip,$state,$id);
			header("Location:" . $_SERVER["REQUEST_URI"]);
			
		}
		else
			$msg="Address already exists";
	}
	
if (isset( $_POST['Delete'])){
		
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
	$index_id = htmlspecialchars($_POST['id']);
	
	pg_prepare($dbconn, "add_address","DELETE FROM spices.address WHERE index_id = $1");
	pg_execute($dbconn, "add_address",array($index_id));
	
	header("Location:" . $_SERVER["REQUEST_URI"]);

	}
	
function checkAdd($street,$street2,$zip,$id){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
	
		$user_id = pg_escape_string(htmlspecialchars($id));
		$street = pg_escape_string(htmlspecialchars($street));
		$street2 = pg_escape_string(htmlspecialchars($street2));
		$zip = pg_escape_string(htmlspecialchars($zip));
		
		$result = pg_prepare($dbconn, "check_address","SELECT * FROM spices.Address WHERE user_id = $1 AND street = $2 AND street2 = $3 AND zip = $4");
		$result = pg_execute($dbconn,"check_address",array($user_id,$street,$street2,$zip));
		if(pg_num_rows($result)==0)
			return 0;
		else
			return 1;
	}
	
function addAddress($fname,$lname,$city,$street,$street2,$zip,$state,$id){

		$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
		
		$user_id = pg_escape_string(htmlspecialchars($id));
		$street = pg_escape_string(htmlspecialchars($street));
		$street2 = pg_escape_string(htmlspecialchars($street2));
		$fname = pg_escape_string(htmlspecialchars($fname));
		$lname = pg_escape_string(htmlspecialchars($lname));
		$city = pg_escape_string(htmlspecialchars($city));
		$state = pg_escape_string(htmlspecialchars($state));
		$zip = pg_escape_string(htmlspecialchars($zip));	

		pg_prepare($dbconn, "add_address","INSERT INTO spices.address (fname, lname, street, street2, city, state_code, zip, user_Id) VALUES ($1,$2,$3,$4,$5,$6,$7,$8)");
		pg_execute($dbconn, "add_address",array($fname,$lname, $street, $street2, $city, $state, $zip, $user_id));
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
	      <form class="navbar-form navbar-right" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Enter Search Term">
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
            <li><a href="#">Order History</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="changepass.php">Change Password</a></li>
            <li class="active"><a href="addressbook.php">Address Book<span class="sr-only">(current)</span></a></li>
            <li><a href="payment.php">Payment Types</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Address Book</h1>
<div id="set-width">
	<?php while ($y = pg_fetch_array($getArray, NULL, PGSQL_ASSOC)){ ?>
	<div class="row clearfix">
		<div class="col-md-12 column">

			<div class="row clearfix">
				<div class="col-md-4 column">
					<form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
						<?php
								echo "<hr>";
                                echo $y["fname"] . " " .  $y["lname"];
								echo "<br>";
								echo $y["street"] . " " .  $y["street2"];
								echo "<br>";
								echo $y["city"] . ", " .  $y["state_code"] . "  " . $y["zip"] ;
								echo "<br>";
								echo "<button type=\"submit\" name=\"Delete\" value=\"Delete\"class=\"btn btn-default\">Delete</button>";
								echo '<input type="hidden" name="id" value="'.$y['index_id'].'">';
								echo "</hr>";
								echo "</form>";
						?>
				</div>
		</div><?php
								}?>	
			<h3 class="page-header">Enter New Address</h1>
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
				<div class="col-md-12 column">
					<div class="form-group">
						<label for="address">Address</label><input class="form-control" name="address" id="address" type="text" required/>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="form-group">
						<label for="address2">Address #2</label><input class="form-control"  name="address2" id="address2" type="text" />
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-md-4 column">
					<div class="form-group">
						<label for="city">City</label><input class="form-control" id="city" name="city" type="text" required/>
					</div>
				</div>
				<div class="col-md-4 column">
					<div class="form-group">
						<label for="state">State</label><select  class="form-control" name="state">
								<option value="">Select</option>
								<?php
									foreach($states as $key => $value):
									echo '<option value="'.$key.'">'.$value.'</option>'; //close your tags!!
									endforeach;
									?>
							</select>
					</div>
				</div>
				<div class="col-md-4 column">
					<div class="form-group">
						<label for="zip">Zip code</label><input class="form-control" id="zip" name="zip" type="number" required/>
					</div>
				</div>
			</div>
				<div class="row clearfix">
					<div class="col-md-6 column">
						<button type="submit" name='Submit' value='Submit' class="btn btn-default">Submit</button>
					</div>
				</div>
	      </form>
		  <h3 class="page-header"><?php echo $msg;?></h3>
		</div>
	</div>
</div>
		  </div>
    </div>
</div>


	<!-- Bottom Navigation Bar -->
</body>
</html>

