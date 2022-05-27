<?php

include('../functions.php');


if(isset($_POST['add_category'])){
    $name_entered = htmlspecialchars($_POST['name']);
    $parent_id_entered = htmlspecialchars($_POST['parent_id']);
    if(is_int($parent_id_entered)) {
      $insertintoCateg = $db->prepare("INSERT INTO categories (name, parent_id) VALUES ('$name_entered', $parent_id_entered)");
    } else {
      $insertintoCateg = $db->prepare("INSERT INTO categories (name) VALUES ('$name_entered')");
    }
      $insertintoCateg->execute();
      header('Location:display_all_categories.php');

}


    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <title>Add Category</title>
      <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body class="admin">
      <div class="header-admin">
          <h2>Add Category</h2>
      </div>
      
      <form method="post" action="">
          <div class="input-group">
            <label>Category Name</label>
            <input type="text" name="name" >
            <br>
            <br>
            <label>Parent ID</label>
          </div>
            <select name="parent_id" id="parent_id">
              <option value=""> None </option>
              <?php 
                $parent_id_query = $db->query("SELECT * from categories");
                $res = $parent_id_query->fetchAll(PDO::FETCH_ASSOC);
                foreach($res as $row) :
                  $id=$row['id'];
                  $name=$row['name']; ?>
                  <option value="<?=$id?>"> <?= $id . ". " . $name ?> </option>
                <?php endforeach ?>
              </select>
              <br>
              <br>
              <br>
          <div class="input-group">
            <button type="submit" class="btn-add" name="add_category">Add</button>
          </div>
      </form>
      <button class="btn_back2" onclick="location.href='../admin.php'" > Back to Admin Page </button>

      <?php if(isset($_POST['add_category'])){
        echo $name_entered . " / " . $parent_id_entered . " / ";} ?>
    </body>
    </html>
