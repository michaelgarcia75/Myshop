<?php

include('../functions.php');

?>

<html>
<head>
    <title>Products</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="admin">
    <div class="header-admin-all">
		<h2>Products</h2>
	</div>
    <div class="display_admin">
        <button class="btn_back" onclick="location.href='../admin.php'" > Back to Admin Page </button>
        <?php
            $recupProducts = $db->query('SELECT * FROM products');
            while($product = $recupProducts->fetch()) :
        ?>
        <p> <img id="product_img_min" src="../<?php echo "{$product['image']}"; ?>" />
            <?php echo "{$product['name']}"; ?>
            <button class="edit" type="button" onclick="location.href='edit_product.php?id=<?php echo $product['id'];?>'">
                <img src="../images/buttons/edit.png">
            </button>
            <button class="trash" type="button" onclick="location.href='delete_product.php?id=<?php echo $product['id'];?>'" onclick="return confirm('Are you sure to delete?')">
                <img src="../images/buttons/trash-a.png">
            </button></p>
        <?php
            endwhile;
        ?>
    </div>
</body>