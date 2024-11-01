<?php
include(base_path("Core/cors.php"));

use Core\App;
use Core\Database;
use Core\Validator;

// Resolve the Database instance
$db = App::resolve(Database::class);

$email = $_POST["email"];
$username = $_POST['username'];
$password = $_POST["password"];

// validate the email username and the password
if (!Validator::email($email)) {
  echo "Invalid email";
  die();
}

if (!Validator::string($username)) {
  echo "Invalid username";
  die();
}

if (!Validator::string($password, 7, 255)) {
  echo "Invalid password, Password should be at least 7 characters and no more than 255.";
  die();
}


// check if the user already exists
$user = $db->query("SELECT * FROM users WHERE email = :email", [
  "email" => $email
])->find();

// if there is a user registered
if ($user) {
  echo "user already exist";
  exit();
} else {
  // if not, save it to the database 
  $db->query("INSERT INTO users(email, username, password) VALUES(:email, :username, :password)", [
    "email" => $email,
    "username" => $username,
    "password" => password_hash($password, PASSWORD_DEFAULT)
  ]);

  echo "user has been created succussfully";
}
