
<?php
	/* Will return the select table for India by default, otherwise will return the table the user selected */
	$_GET['cId'] = str_replace("-"," ",$_GET['cId']); 
	$cId = empty($_GET['cId']) ? 'Indian' : $_GET['cId'];

	//Connecting, selecting database
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs")
		or die('Could not connect:'.pg_last_error());
		
	//Selecting the name of spices by the alphabet
	$result = pg_prepare($dbconn, "search_by_category", 'SELECT A.name, A.descr AS description, A.price, A.size FROM Spices.spices AS A INNER JOIN Spices.spice_category AS B USING (id) WHERE B.category = $1');
	$result = pg_execute($dbconn, "search_by_category", array($cId));
	/* Will return the total number of spices that is found */
	echo"<br><p>There are <i>".pg_num_rows($result)." </i>spices found.</p>\n";
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
				for($j = 0; $j < $i; ++$j)
					echo "\t\t<th>".pg_field_name($result,$j)."</th>\n";
			echo "\t<tr>\n";
			echo "</thead>";
			
			echo "<tbody>\n";		
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
				echo "\t<tr>\n";
				foreach($line as $col_value){
					/* Will add a $ before each price */
					if($col_value == $line['price']){
						echo "\t\t<td>$".$col_value."</td>\n";
					}
					/* Will add "oz" after each size number */
					else if($col_value == $line['size']){
						echo "\t\t<td>".$col_value." oz</td>\n";
					}
					/* Otherwise just print out the value */
					else
						echo "\t\t<td>".$col_value."</td>\n";
				}	
				echo "\t</tr>\n";
			}
			echo "</tbody>\n";
		?>
	</table>
</body>
</html>
