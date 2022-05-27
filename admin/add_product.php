<?php

include('../functions.php');


if(isset($_POST['add_product'])){
    $name_entered = htmlspecialchars($_POST['name']);
    $price_entered = htmlspecialchars($_POST['price']);
    $category_id_entered = htmlspecialchars($_POST['category_id']);
    $image_entered = htmlspecialchars($_POST['image']);
    $insertintoProduct = $db->prepare("INSERT INTO products (name, price, category_id, image) VALUES ('$name_entered', '$price_entered', '$category_id_entered', '$image_entered')");
    $insertintoProduct->execute();
    header('Location:display_all_products.php');
}


    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <title>Add Product</title>
      <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body class="admin">
      <div class="header-admin">
          <h2>Add Product</h2>
      </div>
        
      <form method="post" action="">
          <div class="input-group">
            <label>Productname</label>
            <input type="text" name="name" >
          </div>
          <div class="input-group">
            <label>Price</label>
            <input type="number" name="price">
          </div>
          <div class="input-group">
            <label>Category_id</label>
            <input type="number" name="category_id">
          </div>
          <div class="input-group">
            <label>Image</label>
            <input type="text" name="image">
          </div>
          <div class="input-group">
            <button type="submit" class="btn-add" name="add_product">Add</button>
            
          </div>
      </form>
      <button class="btn_back2" onclick="location.href='../admin.php'" > Back to Admin Page </button>
    </body>
    </html>
