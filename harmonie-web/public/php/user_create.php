<?php

include 'require_admin.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}
$_POST = json_decode(file_get_contents('php://input'), true);

$connection = get_connection();

$username = isset($_POST['username']) ? mysqli_real_escape_string($connection, $_POST['username']) : null;
$email = isset($_POST['email']) ? mysqli_real_escape_string($connection, $_POST['email']) : null;
$password = isset($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;
$role = isset($_POST['role']) ? mysqli_real_escape_string($connection, $_POST['role']) : null;

$password_hash = isset($password) ? password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]) : null;

//events(title, subtitle, link, facebook, datetime, "
if (isset($_POST['id'])) {
  // EDIT
  $id = mysqli_real_escape_string($connection, $_POST['id']);
  $exp = (isset($title) ? "username = '$username', " : "")
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

  $sql = "INSERT INTO users(username, password, " . substr($keys, 0, -2) . ")"
      . " VALUES ('$username', '$password_hash'," . substr($values, 0, -2) . ");";
}

try {
  $result = $connection->query($sql);
} catch (Exception $e) {
  http_response_code(402);
  header('Content-Type: application/json');
  echo json_encode($e, true);
} finally {
  $connection->close();
}

http_response_code(201);
exit();

?>