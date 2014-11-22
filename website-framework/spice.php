<?php
	/* Will return the select table for A by default, otherwise will return the table the user selected */
	$id = htmlspecialchars($_GET["id"]);
	//Connecting, selecting database
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs")
		or die('Could not connect:'.pg_last_error());
	
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	//Selecting the name of spices by the alphabet
	$result = pg_prepare($dbconn, "search_by_alpha", 'SELECT name, descr AS description, price, size, id, food FROM Spices.spices WHERE id = $1');
	$result = pg_execute($dbconn, "search_by_alpha", array($id));
	
	$result2 = pg_prepare($dbconn, "category", 'SELECT category FROM Spices.Spice_Category WHERE id = $1');
	$result2 = pg_execute($dbconn, "category", array($id));

	session_start();

//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
	$return_url = base64_decode($_GET["return_url"]); //return url
	$_SESSION["products"]=NULL;
	header('Location:'.$return_url);
}

//add item in shopping cart
if(isset($_POST["type"]) && $_POST["type"]=='add')
{
	
	$product_id 	= filter_var($_POST["id"], FILTER_SANITIZE_STRING); //product code
	$quantity 	= filter_var($_POST["quantity"], FILTER_SANITIZE_NUMBER_INT); //product code
	$return_url 	= base64_decode($_POST["return_url"]); //return url
	
	//limit quantity for single product
	if($quantity > 10){
		die('<div align="center">This demo does not allowed more than 10 quantity!<br /><a href="http://sanwebe.com/assets/paypal-shopping-cart-integration/">Back To Products</a>.</div>');
	}
	
	$result3 = pg_prepare($dbconn, "search_by_alpha", 'SELECT name, price FROM Spices.spices WHERE id = $1 LIMIT 1');
	$result3 = pg_execute($dbconn, "search_by_alpha", array($product_id));
	$line2 = pg_fetch_array($result3, NULL, PGSQL_ASSOC);
	
	
	if ($line2['name']) { //we have the product info 
		echo "hi";
		//prepare array for the session variable
		$new_product = array(
									array(
										'name'=>$line2['name'],
										'id'=>$product_id,
										'qty'=>$quantity, 
										'price'=>$line2['price']));
		
		if(isset($_SESSION["products"])) //if we have the session
		{
			$found = false; //set found item to false
			
			foreach ($_SESSION["products"] as $cart_itm) //loop through session array
			{
				if($cart_itm["id"] == $product_id){ //the item exist in array

					$product[] = array('name'=>$cart_itm["name"], 'id'=>$cart_itm["id"], 'qty'=>$quantity, 'price'=>$cart_itm["price"]);
					$found = true;
				}else{
					//item doesn't exist in the list, just retrive old info and prepare array for session var
					$product[] = array('name'=>$cart_itm["name"], 'id'=>$cart_itm["id"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
				}
			}
			
			if($found == false) //we didn't find item in array
			{
				//add new user item in array
				$_SESSION["products"] = array_merge($product, $new_product);
			}else{
				//found user item in array list, and increased the quantity
				$_SESSION["products"] = $product;
			}
			
		}else{
			//create a new session var if does not exist
			$_SESSION["products"] = $new_product;
		}
		
	}
	

}

//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{
	
	$product_id 	= $_GET["removep"]; //get the product code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["products"] as $cart_itm) //loop through session array var
	{
		if($cart_itm["id"]!=$product_id){ //item does,t exist in the list
			$product[] = array('name'=>$cart_itm["name"], 'id'=>$cart_itm["id"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
		}
		
		//create a new product list for cart
		$_SESSION["products"] = $product;
	}
	
	header('Location:'.$return_url);
}

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
						<form id="update" method="post" action="">
						<?php $line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								if($line['size'] != null){
									echo "<h4 class=pull-right>".$line['size']." oz.</h4>";
								}
                                echo  "<h4>".$line['name']."</a>"; 
								echo "</h4>";
								echo "<p>".$line['description']."</p>";
								echo "<br>";
								echo "<p><strong>Pairs well with: </strong>".$line['food']."</p>";
								echo "<h4 class=pull-right>$".$line['price']."</h4>";
								echo '<input type="hidden" name="id" value="'.$line['id'].'">';
								echo '<input type="hidden" name="type" value="add">';
								echo '<input type="hidden" name="return_url" value="'.$current_url.'">';?>
						 <select class="btn " name="quantity">
								<?php
									for($i=1;$i<=5;$i++)  {
									echo "<option value='$i'>$i</option>";
									} ?>
						</select>
						<button class="btn btn-success">Add To Cart</button></div>
						
                        </div>
						</form>
				

                        </div>
                    </div>
    </table>
	
	<div class="shopping-cart">
<h2>Your Shopping Cart</h2>
<?php
if(isset($_SESSION["products"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li>';
        echo '<span><a href="cart_update.php?removep='.$cart_itm["id"].'&return_url='.$current_url.'">&times;</a></span>';
        echo '<h3>'.$cart_itm["name"].'</h3>';
        echo '<div>Qty : '.$cart_itm["qty"].'</div>';
        echo '<div >Price :$'.$cart_itm["price"].'</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
    echo '</ol>';
    echo '<span><strong>Total : $ '.$total.'</strong> <a href="view_cart.php">Check-out!</a></span>';
	echo '<span><a href="cart_update.php?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
}else{
    echo 'Your Cart is empty';
}
?>
</div>
</body>

</html>
