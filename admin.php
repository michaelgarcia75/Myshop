<?php 

  include('functions.php');

  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['user']);
  	header("location: signin.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="admin">

	<div class="header-admin">
		<h2>Admin Page</h2>
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
			<p> <img src="images/avatar/avatar_admin.png" class="avatar_admin" >
			<div class='admin_name'>
			<?php echo $_SESSION['user']['username']; ?> <img src="images/avatar/lightsaber_icon.png" class='lightsaber'>
			<br>
			<i style="color: #888;">(<?= ucfirst($_SESSION['user_type']); ?>)</i></p>
			<a href="admin.php?logout='1'">Disconnect</a>
			</div>
		<?php endif ?>
	</div>

    <div class="admin_tools">
        <p> <a href="admin/display_all_users.php">Display all users</a> </p>
        <p> <a href="admin/display_all_products.php">Display all products</a> </p>
        <p> <a href="admin/add_product.php">Add product</a> </p>
		<p> <a href="admin/display_all_categories.php">Display all categories</a> </p>
		<p> <a href="admin/add_category.php">Add category</a> </p>
	</div>
		
</body>
</html>