<?php
	/* Will return the select table for A by default, otherwise will return the table the user selected */
	$alphaId = empty($_GET['alphaId']) ? 'A' : $_GET['alphaId'];
	
	//Connecting, selecting database
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs")
		or die('Could not connect:'.pg_last_error());
		
	//Selecting the name of spices by the alphabet
	$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name AS "Name", id FROM Spices.spices WHERE name LIKE $1');
	$result = pg_execute($dbconn, "search_by_alpha", array($alphaId.'%'));
	
?>
<!DOCTYPE html>
<html>
<body>
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
					/* Will add "oz" after each size number */
					else if($col_value == $line['size']){
						echo "\t\t<td>".$col_value." oz</td>\n";
					}
					/* Otherwise just print out the value */
					else
						echo "\t\t<td><a href=http://babbage.cs.missouri.edu/~dmpkb4/k/cs3380/website-framework/spice.php/?id=". $line['id'] . ">".$col_value."</a></td>\n";
				}	
				echo "\t</tr>\n ";
			}
			echo "</tbody>\n";
		?>
	</table>
</body>
</html>
