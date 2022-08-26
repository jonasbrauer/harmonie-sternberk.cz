<?php

// we use session to store current log-in information
session_start();

include 'session.php';


// use for cookie hash
// todo: move to hidden folder
define('SECRET_WORD', 'bibfir%%MyH9u6qh4fv9iQAF6n$2!3n9wppLGc%^7NSpyEVrRnn@^DNhAr');


function get_user($username) {
  // Query user data from the database
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

function validate_password($username, $pass) {
  // Validate supplied password with the hash from the database.
  $user = get_user($username);
  if (isset($user) && password_verify($pass, $user['password'])) {
    return true;
  } else {
    return false;
  }
}

function logout() {
  // LOG-OUT on DELETE
  if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    unset($_SESSION['login']);
    setcookie('rememberme', '', time() - 3600);
    echo "Logged out.";
    exit();
  }
}


function validate_cookie() {
  // CHECK THE SESSION COOKIE FIRST - if already logged-in
  if (isset($_SESSION['login']) && $_SESSION['login']) {
    list($c_username,$cookie_hash) = explode(',',$_SESSION['login']);
    if (password_verify($c_username.SECRET_WORD, $cookie_hash)) {
      // SESSION LOGGED IN
      return $c_username;
    }

    // WRONG SESSION COOKIE
    unset($_SESSION['login']);
    return null;
  }

  // CHECK THE REMEMBERME COOKIE
  if (isset($_COOKIE['rememberme']) && $_COOKIE['rememberme']) {
    list($c_username,$cookie_hash) = explode(',',$_COOKIE['rememberme']);
    if (password_verify($c_username.SECRET_WORD, $cookie_hash)) {
      // SESSION LOGGED IN
      return $c_username;
    }

    // WRONG REMEMBER ME COOKIE
    unset($_COOKIE['rememberme']);
    return null;
  }

}

function login_post() {
  // ...OR initiate login procedure - expect POST data: { username, password }
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

  if (validate_password($username, $password)) {
    // LOGIN COOKIE = USERNAME,HASH(USERNAME,SECRET)
    $_SESSION['login'] = $username.','.password_hash($username.SECRET_WORD, PASSWORD_DEFAULT);
  } else {
    http_response_code(401);
    exit();
  }

  // Set rememberme cookie with 30-day validity
  if (isset($_POST['rememberme']) && $_POST['rememberme']) {
    $cookie_hash = password_hash($username.SECRET_WORD, PASSWORD_DEFAULT);
    setcookie('rememberme', $username.','.$cookie_hash, time() + (3600 * 24 * 30));
  }
  return $username;


}


?>
