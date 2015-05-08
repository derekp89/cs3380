<?php
	session_start();
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
	//phpinfo(INFO_VARIABLES);
?>

<?php 

	//connect  to the database
 $dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=dmpkb4 user=dmpkb4 password=tigNzr1w") or die("Could not connect: " . pg_last_error());
		
		
	$sname =  htmlspecialchars(ucfirst($_POST["search"]));

  
  //-run  the query against the query function
	$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name AS "Name", id FROM Spices.spices WHERE name LIKE $1 ORDER BY Name ASC');
	$result = pg_execute($dbconn, "search_by_alpha", array('%'.$sname.'%'));
  
  
  //-create  while loop and loop through result set


?>
<!DOCTYPE html>
<html>
<head>
	<title>About Us</title>
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
		p {
		    font-size: 22px;
		}
		#image-wrap{
			padding: auto;
			margin: auto;
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

	<table class="table table-hover">
		<?php
			//print table headers
			echo "<thead>";
			echo "\t<tr>\n";
				$i = pg_num_fields($result);

			echo "\t\t<th style=text-align:center>".pg_field_name($result,$j)."</th>\n";
			echo "\t<tr>\n";
			echo "</thead>";
			
			echo "<tbody>\n";		
			while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				echo "\t<tr style=text-align:center>\n";
				foreach($line as $col_value){
					/* Will add a $ before each price */
					if($col_value == $line['id']){
					
					}
					/* Otherwise just print out the value */
					else
						echo "\t\t<td><a href=spice.php?id=". $line['id'] . ">".$col_value."</a></td>\n";
				}	
				echo "\t</tr>\n ";
			}
			echo "</tbody>\n";
		?>
	</table>
</body>
</html> 