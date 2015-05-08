<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	
	if(isset($_SESSION['username'])) //if a session exists send client to home.php
		header("Location: home.php");
	
	if (isset( $_POST['Submit'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		
		//sees if username and password are correct
	  if(checkUserPass($username,$password)==1){
	  	$_SESSION['username'] = $username;
		header("Location: home.php");
		forceHTTPS();
	  }else 
	   		echo "<br><div align=center><h4>Invalid username or password,  please try again</h4></div>"; 	
		
  }
  
  function checkUserPass($username,$password) {
		
			$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
			
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
	
	function forceHTTPS(){
  $httpsURL = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  if( !isset( $_SERVER['HTTPS'] ) || $_SERVER['HTTPS']!=='on' ){
    if( !headers_sent() ){
      header( "Status: 301 Moved Permanently" );
      header( "Location: $httpsURL" );
      exit();
    }else{
      die( '<script type="javascript">document.location.href="'.$httpsURL.'";</script>' );
    }
  }
}
  
?>	

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>The Spice Shop</title>
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

</head>
<body>
<!-- Top Navigation Bar -->
<?php include('nav.php'); ?>
	
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">Welcome to The Spice Shop</h1>
				</br>
				</br>
				</br>
                <div class="account-wall">
                    <form class="form-signin" id='login' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required autofocus>
                        </br>
                        <input type="password" name="password" class="form-control" id="password"placeholder="Password" required>
                        </br>
                         <button class="btn btn-lg btn-primary btn-block" type="Submit" name='Submit' value='Submit'>Sign in</button>
                        <span class="clearfix"></span>
                    </form>
                </div>
                </br>
                <a href="registration.php" class="text-center new-account">Create an account </a>
            </div>
        </div>
    </div>

	
<!-- Bottom Navigation Bar -->

</body>
</html>