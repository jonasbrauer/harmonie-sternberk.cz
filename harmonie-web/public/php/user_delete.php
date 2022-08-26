<?php

include 'require_admin.php';

if( $_SERVER["REQUEST_METHOD"] !== 'POST' ) {
  http_response_code(405);
  exit();
}

$_POST = json_decode(file_get_contents('php://input'), true);
if( !isset($_POST['username']) ) {
  http_response_code(400);
  exit();
}

$connection = get_connection();
$username = mysqli_real_escape_string($connection, $_POST['username']);
$sql = "DELETE FROM users WHERE username = '$username'";
execute_sql($sql, $connection);

http_response_code(200);

?>