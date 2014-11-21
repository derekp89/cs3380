<?php
	/* Will return the select table for A by default, otherwise will return the table the user selected */
	$id = htmlspecialchars($_GET["id"]);
	//Connecting, selecting database
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs")
		or die('Could not connect:'.pg_last_error());
		
	//Selecting the name of spices by the alphabet
	$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name, descr AS description, price, size, id FROM Spices.spices WHERE id = $1');
	$result = pg_execute($dbconn, "search_by_alpha", array($id));
	
	$result2 = pg_prepare($dbconn, "category", 'SELECT category FROM Spices.Spice_Category WHERE id = $1');
	$result2 = pg_execute($dbconn, "category", array($id));

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
</head>
</script>
<body>
    <table class="table table-hover">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <p class="lead">Categories</p>
                    <div class="list-group">
					<?php while ($line = pg_fetch_array($result2, NULL, PGSQL_ASSOC)){
								foreach($line as $col_value)
                                echo "<a href=# class=list-group-item active>" .$col_value . "</a>";
								}?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="thumbnail">
                        <img class="img-responsive" src="http://placehold.it/800x300" alt="">
                        <div class="caption-full">
						<?php $line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
                                echo  "<h4>".$line['name']."</a>"; 
								echo "</h4>";
								echo "<p>".$line['description']."</p>";
								echo "<h4 class=pull-right>$".$line['price']."</h4>";?>
						 <select class="btn " name="quantity">
								<?php
									for($i=1;$i<=5;$i++)  {
									echo "<option value='$i'>$i</option>";
									} ?>
						</select>
						<button class="btn btn-success">Add To Cart</button></div>
                        </div>

                        </div>
                    </div>
    </table>
</body>

</html>
