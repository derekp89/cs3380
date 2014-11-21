<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>The Spice Shop</title>
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
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">Welcome to The Spice Shop</h1>
				</br>
				</br>
				</br>
				</br>
                <div class="account-wall">
                    <form class="form-signin" id='login' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required autofocus>
                        <input type="password" name="password" class="form-control" id="password"placeholder="Password" required>
                         <button class="btn btn-lg btn-primary btn-block" type="Submit" name='Submit' value='Submit'>
                            Sign in</button>
                        <span class="clearfix"></span>
                    </form>
                </div>
                <a href="http://babbage.cs.missouri.edu/~cs3380f14grp13/cs3380/website-framework/registration.php" class="text-center new-account">Create an account </a>
            </div>
        </div>
    </div>
<?php
	session_start();
	
	if(isset($_SESSION['username'])) //if a session exists send client to home.php
		printf("<script>location.href='mycategory.html'</script>");

	if (isset( $_POST['Submit'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		
		//sees if username and password are correct
	  if(checkUserPass($username,$password)==1){
	  	$_SESSION['username'] = $username;
	  	printf("<script>location.href='mycategory.html'</script>");
	  }else 
	  		echo "<br><div align=center><h4>Invalid username or password,  please try again</h4></div>"; 	
		
  }
  
  function checkUserPass($username,$password) {
		
			$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs") or die("Could not connect: " . pg_last_error());
			
			$query = "SELECT password_hash FROM spices.Users WHERE username LIKE $1";
			pg_prepare($dbconn,"login",$query);
			
			$username = pg_escape_string(htmlspecialchars($username));
			$password = pg_escape_string(htmlspecialchars(sha1($password)));

			$result = pg_execute($dbconn, "login", array($username));
			$line = pg_fetch_array($result, null, PGSQL_ASSOC);
			$pass = $line['password_hash'];
			
	if($pass === $password){   
		return 1;
	}else{
		return 0;
	}
	
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