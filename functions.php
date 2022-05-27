<?php
if (session_id() == "")
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

define('ERROR_LOG_FILE', 'errors.log');

// connect to the database
$db = connect_db('localhost', 'fdizes', 'azerty', 3306, 'my_shop');

function connect_db($host, $username, $passwd, $port, $db) {

  try {
      return new PDO("mysql:host=$host;dbname=$db;port=$port", $username, $passwd);
  } catch (PDOException $e) {
      $error = $e->getMessage();
      $str = "PDO ERROR: $error storage in ". ERROR_LOG_FILE ."\n";
      file_put_contents(ERROR_LOG_FILE, $str, FILE_APPEND);
      echo $str;
  }
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  register();
}

function register() {

  global $db, $errors, $username, $email;

  // receive all input values from the form
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password_1 = $_POST['password_1'];
  $password_2 = $_POST['password_2'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // Check if user/email already exists
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $query = $db->prepare($user_check_query);
  $query->execute();
  $user=$query->fetchAll(PDO::FETCH_ASSOC);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = password_hash($password_1, PASSWORD_DEFAULT); //encrypt the password

  	$insert_query = "INSERT INTO users (username, password, email) 
  			      VALUES('$username', '$password', '$email')";
    $query = $db->prepare($insert_query);
    $query->execute();

    $logged_in_user_id = $db->lastInsertId();
  	$_SESSION['user'] = getUserById($logged_in_user_id);
    $_SESSION['user_type'] = "User";
  	$_SESSION['success'] = "Registration successful, welcome !";
  	header('location: index.php');
  }
}


// LOGIN USER

if (isset($_POST['login_user'])) {
  login();
}

function login() {

  global $db, $errors, $username, $email;

  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username)) {
      array_push($errors, "Username is required");
  }
  if (empty($password)) {
      array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {

    $user_check_query = "SELECT * FROM users WHERE username='$username'"; 
    $query = $db->prepare($user_check_query);
    $query->execute();
    $loggedInUser=$query->fetchAll(PDO::FETCH_ASSOC);

    $password_hash = $loggedInUser[0]["password"];
      if (password_verify($password, $password_hash)) {

        $_SESSION['user'] = $loggedInUser[0];
        $_SESSION['success'] = "Login successful";

        if ($loggedInUser[0]['admin'] == 1) {
          $_SESSION['user_type'] = "Admin";
          header('location: admin.php');
        } else {
          $_SESSION['user_type'] = "User";
          header('location: index.php');
        }
      } else {
          array_push($errors, "Wrong username/password combination");
      }
  }
}

function getUserById($id) {

	global $db;

	$user_check_query = "SELECT * FROM users WHERE id=" . $id;
  $query = $db->prepare($user_check_query);
  $query->execute();
  $user=$query->fetchAll(PDO::FETCH_ASSOC);
	return $user[0];
}

function display_error() {

	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}


?>