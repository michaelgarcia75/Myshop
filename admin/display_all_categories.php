<?php

include('../functions.php');

?>

<html>
<head>
    <title>Categories</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="admin">
<div class="header-admin-all">
		<h2>Categories</h2>
	</div>
    <div class="display_admin">
        <button class="btn_back" onclick="location.href='../admin.php'" > Back to Admin Page </button>
        <?php
            $recupCategs = $db->query('SELECT * FROM categories');
            while($categ = $recupCategs->fetch()) :
        ?>
        <p> <?php echo "{$categ['name']}"; ?> 
        <button class="edit" type="button">
            <img src="../images/buttons/edit.png">
        </button>
        <button class="trash" type="button" onclick="return confirm('Are you sure to delete?')">
            <img src="../images/buttons/trash-a.png">
        </button></p>
        <?php
            endwhile;
        ?>
    </div>
</body>


