<?php
	session_start();
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

		.tabs-bg-highlight{
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
		/* Will create three dynamic tabs */
		$(function() {
			$( "#search-by-tabs, #tabs-1" ).tabs();
			$( "#tabs-2" ).tabs();
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
				$(this).addClass("tabs-bg-highlight");
				$("#tabs-1 li").not(this).removeClass("tabs-bg-highlight");
			});
		});
		
		$(function() {
			$( "#tabs-2 li" ).click(function(){
				$(this).addClass("tabs-bg-highlight");
				$("#tabs-2 li").not(this).removeClass("tabs-bg-highlight");
			});
		});
	</script>
	<script type="text/javascript">
		/* Will update the alphabet content box depending on the letter user chose to search by */
		function updateAlpha(alphaId){
			$.get("search_by_alphabet_handler.php",
			{ "alphaId": alphaId },
			function(data){
				$('#'+alphaId).html(data);
			});
		}

		/* Will update the category content box depending on the category user chose to search by */
		function updateCategory(cId){
			$.get("search_by_category_handler.php",
			{ "cId": cId },
			function(data){
				$('#'+cId).html(data);
			});
		}
		
		/* Will apply the function updateAlpha on the <li> element that the user clicked on */
		$(function(){
			$("#alpha-tabs-list li").click(
				function(){
					updateAlpha(this.textContent);
			});
		});
		
		/* Will apply the function updateCategory on the <li> element that the user clicked on */
		$(function(){
			$("#category-tabs-list li").click(
				function(){
					console.log(this.textContent);
					updateCategory(this.textContent);
			});
		});
		
		/* for the drop-down menu (Shop For Spices) on navbar */
		$(function(){
			$("#alpha_cate li").click(
				function(){
					console.log(this.id);
					if(this.id == "menu_cate"){
						$("#cate").addClass("active");
						$("#alpha").removeClass("active");
						SetActiveTab('search-by-tabs',1);
						//$("#search-by-tabs").tabs({active: 1});
					}
					else{
						$("#alpha").addClass("active");
						$("#cate").removeClass("active");
						SetActiveTab('search-by-tabs',0);
						//$("#search-by-tabs").tabs({active: 0});						
					}
			});
		});
		
		function SetActiveTab(tabControl, tabNumber){
			$(function(){
				$('#'+tabControl).tabs({active: tabNumber});
			});
		}
		
		<?php
			$cate = str_replace(" ","-",$_POST['cate']);
			switch($cate){
				case "Indian": $cate_index = 0; break;
				case "Middle-Eastern": $cate_index = 1; break;
				case "Thai": $cate_index = 2; break;
				case "Scandinavian": $cate_index = 3; break;
				case "Cajun": $cate_index = 4; break;
				case "Mexican": $cate_index = 5; break;
				case "Spanish": $cate_index = 6; break;
				case "Greek-and-Turkish": $cate_index = 7; break;
				case "Eastern-European": $cate_index = 8; break;
				case "Caribbean": $cate_index = 9; break;
				case "Italian": $cate_index = 10; break;
				case "English": $cate_index = 11; break;
				case "German": $cate_index = 12; break;
				case "Irish": $cate_index = 13; break;
				case "Hungarian": $cate_index = 14; break;
				case "Chinese-and-Far-Eastern": $cate_index = 15; break;
				case "French": $cate_index = 16; break;
			}
			if(isset($_POST['cate'])){
				//echo "updateCategory(".$_POST['cate'].");",
				echo"$(function(){",
						//change style of search-by-tabs
						"$('#cate').addClass('active');",
						"$('#alpha').removeClass('active');",
						//set active search-by-tabs
						"SetActiveTab('search-by-tabs',1);",
						//set active category tabs
						"SetActiveTab('tabs-2',".$cate_index.");",
						//update category content box
						"updateCategory('".$cate."');",
						//change highlight of category tabs
						"$('#".$cate."-p').addClass('tabs-bg-highlight');",
						"$('#tabs-2 li').not('#".$cate."-p').removeClass('tabs-bg-highlight');",
					"});";
			}	
		?>

	</script>
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
  	          <!--<form action="alpha_category.php" method="POST">-->
  	          <ul id="alpha_cate" class="dropdown-menu" role="menu">
  	            <li id="menu_alpha"><a href="#">By Alphabet</a></li>
				<li class="divider"></li>
  	            <li id="menu_cate"><a href="#">By Category</a></li>
  	           <!-- <input type="hidden" name="menu_act" value="">-->
  	          </ul>
  	      <!--    </form>-->
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
	
	<div id="body_wrapper">
		<div id="Title">
			<h1>THE SPICE SHOP</h1>
		</div>

		<div id="search-by-tabs">
			<ul id="search-by" class="nav nav-tabs">
		 	   <li id="alpha" class="active">
		 		  <a href="#tabs-1">Alphabetical</a>
			  </li>
			  <li id="cate"><a href="#tabs-2">By category</a></li>
			</ul>
			<div id="search-by-tab-content">
				<div id="tabs-1">
					<ul id="alpha-tabs-list" class="nav nav-tabs">
				 	  <li class="tabs-bg-highlight"><a href="#A">A</a></li>
					  <li><a href="#B">B</a></li>
					  <li><a href="#C">C</a></li>
					  <li><a href="#D">D</a></li>
				 	  <li><a href="#E">E</a></li>
					  <li><a href="#F">F</a></li>
					  <li><a href="#G">G</a></li>
					  <li><a href="#H">H</a></li>
				 	  <li><a href="#I">I</a></li>
					  <li><a href="#J">J</a></li>
					  <li><a href="#K">K</a></li>
					  <li><a href="#L">L</a></li>
				 	  <li><a href="#M">M</a></li>
					  <li><a href="#N">N</a></li>
					  <li><a href="#O">O</a></li>
					  <li><a href="#P">P</a></li>
					  <li><a href="#Q">Q</a></li>
					  <li><a href="#R">R</a></li>
					  <li><a href="#S">S</a></li>
				 	  <li><a href="#T">T</a></li>
					  <li><a href="#U">U</a></li>
					  <li><a href="#V">V</a></li>
					  <li><a href="#W">W</a></li>
				 	  <li><a href="#X">X</a></li>
					  <li><a href="#Y">Y</a></li>
					  <li><a href="#Z">Z</a></li>
					</ul>
					<div id="alphabet-content-box">
						<div id="A">Select a letter to start with.</div>
						<div id="B"></div>
						<div id="C"></div>
						<div id="D"></div>
						<div id="E"></div>
						<div id="F"></div>
						<div id="G"></div>
						<div id="H"></div>
						<div id="I"></div>
						<div id="J"></div>
						<div id="K"></div>
						<div id="L"></div>
						<div id="M"></div>
						<div id="N"></div>
						<div id="O"></div>
						<div id="P"></div>
						<div id="Q"></div>
						<div id="R"></div>
						<div id="S"></div>
						<div id="T"></div>
						<div id="U"></div>
						<div id="V"></div>
						<div id="W"></div>
						<div id="X"></div>
						<div id="Y"></div>
						<div id="Z"></div>
					</div>
				</div>
				<div id="tabs-2">
					<ul id="category-tabs-list" class="nav nav-tabs">
					  <li id="Indian-p" class="tabs-bg-highlight"><a href="#Indian">Indian</a></li>
					  <li id="Middle-Eastern-p"><a href="#Middle-Eastern">Middle-Eastern</a></li>
					  <li id="Thai-p"><a href="#Thai">Thai</a></li>
					  <li id="Scandinavian-p"><a href="#Scandinavian">Scandinavian</a></li>
					  <li id="Cajun-p"><a href="#Cajun">Cajun</a></li>
					  <li id="Mexican-p"><a href="#Mexican">Mexican</a></li>
					  <li id="Spanish-p"><a href="#Spanish">Spanish</a></li>
					  <li id="Greek-and-Turkish-p"><a href="#Greek-and-Turkish">Greek-and-Turkish</a></li>
					  <li id="Eastern-European-p"><a href="#Eastern-European">Eastern-European</a></li>
					  <li id="Caribbean-p"><a href="#Caribbean">Caribbean</a></li>
					  <li id="Italian-p"><a href="#Italian">Italian</a></li>
					  <li id="English-p"><a href="#English">English</a></li>
					  <li id="German-p"><a href="#German">German</a></li>
					  <li id="Irish-p"><a href="#Irish">Irish</a></li>
					  <li id="Hungarian-p"><a href="#Hungarian">Hungarian</a></li>
					  <li id="Chinese-and-Far-Eastern-p"><a href="#Chinese-and-Far-Eastern">Chinese-and-Far-Eastern</a></li>
					  <li id="French-p"><a href="#French">French</a></li>
					</ul>
					<div id="alphabet-content-box">
						<div id="Indian">Select a category to start with.</div>
						<div id="Middle-Eastern"></div>
						<div id="Thai"></div>
						<div id="Scandinavian"></div>
						<div id="Cajun"></div>
						<div id="Mexican"></div>
						<div id="Spanish"></div>
						<div id="Greek-and-Turkish"></div>
						<div id="Eastern-European"></div>
						<div id="Caribbean"></div>
						<div id="Italian"></div>
						<div id="English"></div>
						<div id="German"></div>
						<div id="Irish"></div>
						<div id="Hungarian">foo</div>
						<div id="Chinese-and-Far-Eastern"></div>
						<div id="French"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Bottom Navigation Bar -->
	<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
	  <div class="container">
		  
	  </div>
	</nav>
</body>
</html>
