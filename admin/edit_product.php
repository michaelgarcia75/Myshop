<?php

include('../functions.php');

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getId = $_GET['id'];
    $query = $db->prepare('SELECT * FROM products WHERE id = ?');
    $query->execute(array($getId));
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $product = $res[0];
    
    $name = $product['name'];
    $price = $product['price'];
    $category_id = $product['category_id'];
    $image = $product['image'];


    if(isset($_POST['edit_product'])){
        $name_entered = htmlspecialchars($_POST['name']);
        $price_entered = htmlspecialchars($_POST['price']);
        $category_id_entered = htmlspecialchars($_POST['category_id']);
        $image_entered = htmlspecialchars($_POST['image']);
        $updateProduct = $db->prepare('UPDATE products SET name = ? , price = ?, category_id = ?, image = ? WHERE id = ?');
        $updateProduct->execute(array($name_entered, $price_entered, $category_id_entered, $image_entered, $getId));
        header('Location:display_all_products.php');
    }
}

    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <title>Edit Product</title>
      <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body class="admin">
      <div class="header-admin">
          <h2>Edit Product</h2>
      </div>
        
      <img id="product_img" src="../<?php echo $image; ?>" />

      <form method="post" action="">
          <div class="input-group">
            <label>Productname</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
          </div>
          <div class="input-group">
            <label>Price</label>
            <input type="number" name="price" value="<?php echo $price; ?>">
          </div>
          <div class="input-group">
            <label>Category_id</label>
            <input type="number" name="category_id" value="<?php echo $category_id; ?>">
          </div>
          <div class="input-group">
            <label>Image</label>
            <input type="text" name="image" value="<?php echo $image; ?>">
          </div>
          <div class="input-group">
            <button type="submit" class="btn-register" name="edit_product">Edit</button>
          </div>
      </form>
    </body>
    </html>
