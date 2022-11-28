<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}

include 'session.php';


$_POST = json_decode(file_get_contents('php://input'), true);
if( !isset($_POST['event_id']) ) {
  http_response_code(400);
  exit();
}

if (isset($_COOKIE['liked_events'])){
  $liked = explode(",", $_COOKIE['liked_events']);
  if ( in_array(strval($_POST["event_id"]), $liked) ) {
    http_response_code(418);
    exit();
  }
}
$connection = get_connection();
$event_id = mysqli_real_escape_string($connection, $_POST['event_id']);
$sql = "SELECT likes FROM events WHERE id='$event_id';";
$events = execute_sql($sql, $connection);

if ( count($events) !== 1 ) {
  http_response_code(404);
  exit();
}

$new_likes_count = $events[0]['likes'] += 1;
$sql = "UPDATE events SET likes='$new_likes_count' WHERE id='$event_id';";
execute_sql($sql, $connection);

if (isset($_COOKIE['liked_events'])){
  $liked = $_COOKIE['liked_events'] . "," . strval($event_id);
} else {
  $liked = strval($event_id);
}
setcookie("liked_events", $liked, 2147483647);

$response = array();
$response['event_id'] = $event_id;
$response['likes'] = $new_likes_count;

header('Content-Type: application/json');
echo json_encode($response, true);

?>