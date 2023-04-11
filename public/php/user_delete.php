<?php

include 'require_admin.php';

if( $_SERVER["REQUEST_METHOD"] !== 'POST' ) {
  http_response_code(405);
  exit();
}

$_POST = json_decode(file_get_contents('php://input'), true);
if( !isset($_POST['id']) ) {
  http_response_code(400);
  exit();
}

$connection = get_connection();
$id = mysqli_real_escape_string($connection, $_POST['id']);
$sql = "DELETE FROM users WHERE id = '$id'";
execute_sql($sql, $connection);

http_response_code(200);

?>