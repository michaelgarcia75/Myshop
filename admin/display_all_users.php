<?php

include('../functions.php');

?>

<html>
<head>
    <title>Users</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body class="admin">
    <div class="header-admin-all">
		<h2>Users</h2>
	</div>
    <div class="display_admin">
        <button class="btn_back" onclick="location.href='../admin.php'" > Back to Admin Page </button>
    <?php
        $recupUsers = $db->query('SELECT * FROM users');
        while($user = $recupUsers->fetch()) :
    ?>
    <p> <?php echo "{$user['username']}"; ?> 
    <button class="edit" type="button" onclick="location.href='edit_user.php?id=<?php echo $user['id'];?>'">
        <img src="../images/buttons/edit.png">
    </button>
    <button class="trash" type="button" onclick="location.href='delete_user.php?id=<?php echo $user['id'];?>'" onclick="return confirm('Are you sure to delete?')">
        <img src="../images/buttons/trash-a.png">
    </button></p>
    <?php
        endwhile;
    ?>
    </div>
</body>
