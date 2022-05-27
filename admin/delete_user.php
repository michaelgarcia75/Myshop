<?php

include('../functions.php');

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getId = $_GET['id'];
    $deleteUser = $db->prepare('DELETE FROM users WHERE id = ?');
    $deleteUser->execute(array($getId));
    header('Location:display_all_users.php');
}


