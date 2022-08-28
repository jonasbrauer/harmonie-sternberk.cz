<?php

include 'require_admin.php';
include 'user.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}
$_POST = json_decode(file_get_contents('php://input'), true);

$connection = get_connection();

$username = validateUsername($connection, $_POST['username']);
$email = validateEmail($connection, $_POST['email']);
$password = isset($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;
$role = isset($_POST['role']) ? mysqli_real_escape_string($connection, $_POST['role']) : null;

$password_hash = isset($password) ? password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]) : null;

// events(title, subtitle, link, facebook, datetime, "
if (isset($_POST['id'])) {
  // EDIT
  $id = mysqli_real_escape_string($connection, $_POST['id']);
  $validated = $_POST['validated'] ? "1" : "0";
  $exp = (isset($validated) ? "validated = $validated, " : "")
  . (isset($username) ? "username = '$username', " : "")
  . (isset($email) ? "email = '$email', " : "")
  . (isset($password_hash) ? "password = '$password_hash', " : "")
  . (isset($role) ? "role = '$role', " : "");
  
  // remove trailing space & comma
  $sql = "UPDATE users SET " . substr($exp, 0, -2) . "WHERE id = $id;";

} else {
  // CREATE
  if (!isset($_POST['username']) || !isset($_POST['password'])) {
    http_response_code(400);
    exit();
  }
  $keys = (isset($email) ? "email, " : "") . (isset($role) ? "role, " : "");
  $values = (isset($email) ? "'$email', " : "") . (isset($role) ? "'$role', " : "");

  $sql = "INSERT INTO users(username, password, validated, " . substr($keys, 0, -2) . ")"
      . " VALUES ('$username', '$password_hash', 1, " . substr($values, 0, -2) . ");";
}

execute_sql($sql, $connection);

http_response_code(201);
exit();

?>