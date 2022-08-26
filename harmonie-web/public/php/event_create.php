<?php

include 'require_admin.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}
$_POST = json_decode(file_get_contents('php://input'), true);


$connection = get_connection();
$title = isset($_POST['title']) ? mysqli_real_escape_string($connection, $_POST['title']) : null;
$datetime = isset($_POST['datetime']) ? mysqli_real_escape_string($connection, $_POST['datetime']) : null;
$type = isset($_POST['type']) ? mysqli_real_escape_string($connection, $_POST['type']) : null;

$subtitle = isset($_POST['subtitle']) ? mysqli_real_escape_string($connection, $_POST['subtitle']) : '';
$link = isset($_POST['link']) ? mysqli_real_escape_string($connection, $_POST['link']) : '';
$facebook = isset($_POST['facebook']) ? mysqli_real_escape_string($connection, $_POST['facebook']) : '';
$datetime_end = isset($_POST['datetime_end']) ? mysqli_real_escape_string($connection, $_POST['datetime_end']) : null;
$location = isset($_POST['location']) ? mysqli_real_escape_string($connection, $_POST['location']) : '';
$info = isset($_POST['info']) ? mysqli_real_escape_string($connection, $_POST['info']) : '';

//events(title, subtitle, link, facebook, datetime, "
if (isset($_POST['id'])) {
  // EDIT
  $id = mysqli_real_escape_string($connection, $_POST['id']);
  $exp = (isset($title) ? "title = '$title', " : "")
  . (isset($subtitle) ? "subtitle = '$subtitle', " : "")
  . (isset($link) ? "link = '$link', " : "")
  . (isset($facebook) ? "facebook = '$facebook', " : "")
  . (isset($datetime) ? "datetime = '$datetime', " : "")
  . (isset($datetime_end) ? "datetime_end = '$datetime_end', " : "")
  . (isset($location) ? "location = '$location', " : "")
  . (isset($info) ? "info = '$info', " : "")
  . (isset($type) ? "type = '$type', " : "");
  // remove trailing space & comma
  $sql = "UPDATE events SET " . substr($exp, 0, -2) . "WHERE id = $id;";
  echo $sql;

} else {
  // CREATE
  if (!isset($_POST['title']) || !isset($_POST['type']) || !isset($_POST['datetime'])) {
    http_response_code(400);
    exit();
  }

  $sql = "INSERT INTO events(title, subtitle, link, facebook, datetime, "
       . (isset($datetime_end) ? "datetime_end, " : "")
       . "type, location, info) VALUES ('$title', '$subtitle', '$link', '$facebook', '$datetime', "
       . (isset($datetime_end) ? "'$datetime_end', " : "")
       . "'$type', '$location', '$info');";
}

execute_sql($sql, $connection);

http_response_code(200);
exit();

?>