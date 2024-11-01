<?php
include(base_path("Core/cors.php"));

use Core\App;
use Core\Database;
use Core\Validator;

// Resolve the Database instance
$db = App::resolve(Database::class);

$email = $_POST["email"];
$password = $_POST["password"];

// validate the email username and the password
if (!Validator::email($email)) {
  echo "Invalid email";
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

// if there is not a user registered
if (!$user) {
  echo "user does not exist";
  exit();
}
// if yes, check the password 
if (password_verify(
  $password,
  $user["password"]
)) {
  echo "successfully logged in";
  exit();
} else {
  echo "Invalid password";
  exit();
}
