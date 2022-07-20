<?php

// we use session to store current log-in information
session_start();

include 'session.php';

function get_user($username) {
  $connection=get_connection();
  if ($connection->connect_errno) {
    http_response_code(503);
    exit();
  }
  
  $sql = "SELECT * FROM users WHERE username = '$username';";
  try {
    $result = $connection->query($sql);
  } catch (Exception $e) {
    http_response_code(401);
    exit();
  }
  $connection->close();

  if ($result->num_rows !== 1) {
    http_response_code(401);
    exit();
  }
  return $result->fetch_assoc();
}

function pc_validate($username, $pass) {
  $user = get_user($username);
  if (isset($user) && password_verify($pass, $user['password'])) {
    return true;
  } else {
    return false;
  }
}

// use for cookie hash
// todo: move to DB
$secret_word = 'bibfir%%MyH9u6qh4fv9iQAF6n$2!3n9wppLGc%^7NSpyEVrRnn@^DNhAr';

/**
 * 
 * AUTH SCRIPT
 * 
 * logs users in - sends auth session cookie
 * logs users out (DELETE)
 * validates session cookie - if present
 * 
 * Blocks invalid input, no output on success. 
 * 
 */

// LOG-OUT
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
  unset($_SESSION['login']);
  echo "Logged out.";
  exit();
}

// CHECK THE SESSION COOKIE - if already logged-in
unset($username);
if (isset($_SESSION['login']) && $_SESSION['login']) {
  list($c_username,$cookie_hash) = explode(',',$_SESSION['login']);
  if (password_verify($c_username.$secret_word, $cookie_hash)) {
    // SESSION LOGGED IN
    $username = $c_username;
    // echo "User $username logged-in via session cookie";
    return true;
  } else {
    // WRONG LOGIN COOKIE
    unset($_SESSION['login']);
  }
}


// ...OR initiate login procedure
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(401);
  exit();
}
$_POST = json_decode(file_get_contents('php://input'), true);
if (!isset($_POST['username']) || !isset($_POST['password'])) {
  http_response_code(400);
  exit();
}
$username = $_POST['username'];
$password = $_POST['password'];

if (pc_validate($username, $password)) {
  // LOGIN COOKIE = USERNAME,HASH(USERNAME,SECRET)
  $_SESSION['login'] = $username.','.password_hash($username.$secret_word, PASSWORD_DEFAULT);
  // echo "User $username logged-in via password. Session cookie set.";
} else {
  http_response_code(401);
  exit();
}

// $password = password_hash($password4, PASSWORD_DEFAULT, ['cost' => 15]);
// if(password_verify($password4, $dbpassword)) {

// }


?>
