<?php 

  include('functions.php'); 

  if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: signin.php');
	}
  
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['user']);
  	header("location: signin.php");
  }

  if (isset($_POST['search'])){
	
    $query = !empty($_POST['query']) ? $_POST['query'] : "none";
    $categ = !empty($_POST['categ']) ? $_POST['categ'] : "none";
	$min = !empty($_POST['min']) ? $_POST['min'] : 0;
	$max = !empty($_POST['max']) ? $_POST['max'] : 1000000000;
	$sort = !empty($_POST['sort']) ? $_POST['sort'] : "none" ;

	$str = "index.php?query=" . $query . "&categ=" . $categ . "&min=" . $min . "&max=" . $max . "&sort=" . $sort ;
	header("location: $str");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="background_homepage" >
		<div class="header">
			<h2 id="title">STAR WARS SHOP</h2>
		</div>
		<div class="content">
			<!-- notification message -->
			<?php if (isset($_SESSION['success'])) : ?>
			<div class="success" >
				<h3>
				<?php 
					echo $_SESSION['success']; 
					unset($_SESSION['success']);
				?>
				</h3>
			</div>
			<?php endif ?>

			<!-- logged in user information -->
			<?php  if (isset($_SESSION['user'])) : ?>
				<img src="images/avatar/avatar stromtrooper.png" class="avatar_user" > 
				<div class='usersession_name'>  
					<?php echo $_SESSION['user']['username']; ?>  
					<br> 
					<i style="color: #888;">(<?php echo ucfirst($_SESSION['user_type']); ?>)</i>
					<a href="index.php?logout='1'">Disconnect</a>
				</div> 
				<br>
			<?php endif ?>
		</div>
	</div>		
	<div class="product_flexbox">
		<div class="search">
			<form method="POST" class="searchbuttons" action="index.php">
				<input type="text" class="searchbar" name="query" placeholder="Search...">
				<br>
				<select id="categ" class="category" name="categ" >
					<option value=""> Category </option>
					<?php 
					$parent_id_query = $db->query("SELECT * from categories");
					$res = $parent_id_query->fetchAll(PDO::FETCH_ASSOC);
					foreach($res as $row) :
					$name=$row['name']; ?>
					<option value="<?= $name?>"> <?= $name?> </option>
					<?php endforeach ?>
				</select>
				<br>
				<input type="number" name="min" class="pricemin" placeholder="Price min" min="0"> 
				<br>
				<input type="number" name="max" class="pricemax" placeholder="Price max" max="1000000000">
				<br>
				<select name="sort" class="sort" id="sort">
					<option value=""> Sort </option>
					<option value="alph"> Alphabetically </option>
					<option value="rev_alph"> Reverse Alphabetically </option>
					<option value="inc_price"> Increasing Price </option>
					<option value="dec_price"> Decreasing Price </option>
				<input type="submit" name="search" class="find" value="Find">
			</form>
		</div>
        <?php 
		$str="SELECT * FROM products";
		if(isset($_GET['query'])) {
			$str = $str . " WHERE ";
			$uname=strtoupper($_GET['query']);
			$strName = $uname == "NONE" ? "" : "UPPER(name) LIKE '%$uname%' ";
		}
		if(isset($_GET['categ'])) {
			$categ = $_GET['categ'];
			if ($categ == "none") {
				$strCateg = "";
			} else {
				$queryIdCateg = $db->query("SELECT id FROM categories WHERE name = '$categ' ");
				$recupIdCateg = $queryIdCateg->fetchAll(PDO::FETCH_ASSOC);
				$id = $recupIdCateg[0]['id'];
				$strCateg = "category_id = $id ";
				if ($_GET['query'] != "none") {
					$strCateg = "AND " . $strCateg;
				}
			}
		}
		if(isset($_GET['min']) && isset($_GET['max'])) {
			$min = $_GET['min'];
			$max = $_GET['max'];
			$strPrice = "price BETWEEN $min AND $max";
			if ($_GET['query'] != "none" || $_GET['categ'] != "none") {
				$strPrice = "AND " . $strPrice;
			}
		}
		if(isset($_GET['sort'])){
			$sort = $_GET['sort'];
			switch ($sort) {
				case "alph" : 
					$strSort = " ORDER BY name ASC";
					break;
				case "rev_alph" : 
					$strSort = " ORDER BY name DESC";
					break;
				case "inc_price" : 
					$strSort = " ORDER BY price ASC";
					break;
				case "dec_price" : 
					$strSort = " ORDER BY price DESC";
					break;
				default : $strSort="";
			}
		}

		$str = $str . $strName . $strCateg . $strPrice . $strSort;
		$recupProducts = $db->query($str);
		$res=$recupProducts->fetchAll(PDO::FETCH_ASSOC);
		if(!$res) {
			echo "Product not found";
		} else {
        	foreach($res as $row) :

			?>
				<article class="product_box"> 
				<img src="../<?php echo "{$row['image']}"; ?>" class="image">
				<div class="cadre">
					<div class="prix"><h1><?php echo "{$row['price']}"; ?> $</h1></div>
					<div class="nom"><h1><?php echo "{$row['name']}"; ?></h1></div> 
				</div>
				<iframe class="fb-share-button" src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=button_count&size=small&width=113&height=20&appId" width="113" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
				</article>
			<?php
			endforeach;
		}
    	?>
    </div>


	
		
</body>
</html>