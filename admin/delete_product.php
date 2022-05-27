<?php

include('../functions.php');

if(isset($_GET['id']) && !empty($_GET['id'])){
    $getId = $_GET['id'];
    $deleteProduct = $db->prepare('DELETE FROM products WHERE id = ?');
    $deleteProduct->execute(array($getId));
    header('Location:display_all_products.php');
}
