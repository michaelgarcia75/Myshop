<?php

include('../functions.php');

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getId = $_GET['id'];
    $query = $db->prepare('SELECT * FROM users WHERE id = ?');
    $query->execute(array($getId));
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $user = $res[0];
    
    $username = $user['username'];
    $email = $user['email'];
    $password = $user['password'];
    $isAdmin = $user['admin'];

    if(isset($_POST['edit_user'])){
        $username_entered = htmlspecialchars($_POST['username']);
        $email_entered = htmlspecialchars($_POST['email']);
        $password_entered = htmlspecialchars($_POST['password']);

        
        if(isset($_POST['admin']) AND !empty($_POST['admin'])){
            $isAdmin_entered = htmlspecialchars($_POST['admin']);
        }else{
            $isAdmin_entered = 0;
        }
        if(!empty($password_entered)) {
          $password_hashed = password_hash($password_entered, PASSWORD_DEFAULT);
          $updateUser = $db->prepare('UPDATE users SET username = ? , email = ? , password = ? , admin = ? WHERE id = ?');
          $updateUser->execute(array($username_entered, $email_entered, $password_hashed, $isAdmin_entered, $getId));
        } else {
          $updateUser = $db->prepare('UPDATE users SET username = ? , email = ?, admin = ? WHERE id = ?');
          $updateUser->execute(array($username_entered, $email_entered, $isAdmin_entered, $getId));
        }
        
        header('Location:display_all_users.php');

    }

}

    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <title>Edit User</title>
      <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body class="admin">
      <div class="header-admin">
          <h2>Edit User</h2>
      </div>
        
      <form method="post" action="">
          <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
          </div>
          <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
          </div>
          <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
          </div>
          <div class="input-group">
            <label>Admin</label>
            <input type="checkbox" name="admin" value= "1" 
            <?php if ($isAdmin):?>checked <?php endif?> >
          </div>
          <div class="input-group">
            <button type="submit" class="btn-register" name="edit_user">Edit</button>
          </div>
      </form>
    </body>
    </html>
