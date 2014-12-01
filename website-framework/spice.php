<?php
	/* Will return the select table for A by default, otherwise will return the table the user selected */
	$id = htmlspecialchars($_GET["id"]);
	//Connecting, selecting database
	$dbconn =pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=cs3380f14grp13 user=cs3380f14grp13 password=quyRXtKs")
		or die('Could not connect:'.pg_last_error());
	
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	//Selecting the name of spices by the alphabet
	$result = pg_prepare($dbconn, "search_by_id", 'SELECT name, descr AS description, price, size, id, food FROM Spices.spices WHERE id = $1');
	$result = pg_execute($dbconn, "search_by_id", array($id));
	
	$result2 = pg_prepare($dbconn, "category", 'SELECT category FROM Spices.Spice_Category WHERE id = $1');
	$result2 = pg_execute($dbconn, "category", array($id));

	session_start();

//empty cart by destroying current session
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
	
	
	$result3 = pg_prepare($dbconn, "search_by_id_limit", 'SELECT name, price FROM Spices.spices WHERE id = $1 LIMIT 1');
	$result3 = pg_execute($dbconn, "search_by_id_limit", array($product_id));
	$line2 = pg_fetch_array($result3, NULL, PGSQL_ASSOC);
	
	
	if ($line2['name']) { //we have the product info 
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
<?php
	$log_display = $_SESSION['username'] ? "Logout" : "Log Into Your Account";
	$href_page = $_SESSION['username'] ? "logout.php" : "login.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Browse Spices by Name, Category</title>
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
	</style>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css"/>
	<script src="jquery-ui-1.11.2/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<script src="dist/js/bootstrap.js"></script>
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
  	            <li><a href="alpha_category.php">By Category</a></li>
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

    <table class="table table-hover">
        <div class="container">
            <div class="row">
                <div class="col-xs-2">
                    <p class="lead">Categories</p>
                    <form method="POST" action="alpha_category.php" role="form">
                    <div class="list-group form-group">
					<?php 
						while ($line = pg_fetch_array($result2, NULL, PGSQL_ASSOC)){
							foreach($line as $col_value){
                            //echo "<a href='#' class='list-group-item'>" .$col_value . "</a>";
                            	echo "<button class='btn btn-default' id='".$col_value."'name='cate' value='".$col_value."'>";	
                                echo "<label for='".$col_value."'>".$col_value."</label><br>";  
                                }
							}
					?>
                    </div>
                    </form>
                </div>
                <div class="col-md-7">
                    <div class="thumbnail">
					<?php $line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
                     echo  "<img class=\"img-responsive\" style=\"width:50%;height:50%\"src=\"bigpic/".$line["id"].".png\">\n"; ?>
                        <div class="caption-full">
						<form id="update" method="post" action="">		
						<?php
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
				</div>
    </table>
	
<div class="cart">
<div class="cart-top">
      <div class="cart-top-title">Your Shopping Cart</div>
</div>
<ul>
<?php
if(isset($_SESSION["products"]))
{
    $total = 0;
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li class="cart-item">';
        echo '<div class="cart-item-name"><span><a href="?removep='.$cart_itm["id"].'&return_url='.$current_url.'">&times;</a>'.$cart_itm["name"].'</span></div>';
        echo '<div class="cart-item-desc">Qty : '.$cart_itm["qty"].'</div>';
        echo '<div class="cart-item-price">Price :$'.$cart_itm["price"].'</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
	echo '<div class="cart-bottom">';
    echo '<strong>Total : $'.number_format($total, 2).'</strong>';
	echo ' <a href="cart.php" class="cart-button">Check Out</a>';
	echo '</br><span class="empty-cart"><a href="?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
}else{
    echo '<div class="cart-item-desc" align=center>Your Cart is empty</div>';
}
?>
</div>
</div>

	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
	      <ul class="nav navbar-nav navbar-right">
			<!-- Redirect to About Us page -->
	        <li></li>
		</ul>
	  </div>
	</nav>
</body>
</html>
