<?php
/**
 * Members can request an account creation - without auth - to be confirmed by admins.
 */

include 'user.php';
include 'session.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}
$_POST = json_decode(file_get_contents('php://input'), true);

$connection = get_connection();

$username = isset($_POST['username']) ? validateUsername($connection, $_POST['username']) : null;
$role = 'member'; // ALWAYS force member - admins can adjust later
$password = isset($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;

$email = isset($_POST['email']) ? validateEmail($connection, $_POST['email']) : null;
$password_hash = isset($password) ? password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]) : null;


// CREATE
if (!isset($_POST['username']) || !isset($_POST['password'])) {
  http_response_code(400);
  exit();
}
$keys = (isset($email) ? "email, " : "") . (isset($role) ? "role, " : "");
$values = (isset($email) ? "'$email', " : "") . (isset($role) ? "'$role', " : "");

$sql = "INSERT INTO users(username, password, " . substr($keys, 0, -2) . ")"
    . " VALUES ('$username', '$password_hash'," . substr($values, 0, -2) . ");";


execute_sql($sql, $connection);

http_response_code(201);
exit();

?>