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

<body>
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
		header("Location: mycategory.html");
	
	if (isset( $_POST['Submit'])){
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		
		//sees if username and password are correct
	  if(checkUserPass($username,$password)==1){
	  	$_SESSION['username'] = $username;
	  	header("Location: mycategory.html");
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
  
?>	
	
</body>



</html>