<?php

include 'require_member.php';

/**
 *   EVENT
 *   any public event (concert, competition, etc...)
 * ---------------------------------------------------------
 * title (str)
 * subtitle (str)
 * link (str) - any external links (partner, place, etc...)
 * facebook (str) - link to own facebook event
 * likes (int) - number of likes #TODO
 * datetime (datetime)
 * end_datetime (datetime) - in case of more than 1 day event #TODO
 */

function get_events() {
  $connection = get_connection();
  $sql = "SELECT * FROM events ORDER BY datetime desc;";
  try {
    $result = $connection->query($sql);
  } catch (Exception $e) {
    return array();
  }
  $connection->close();

  $events = array();
  while($row = $result->fetch_assoc()) {
    $events[] = $row;
  }
  return $events;
}

$events = get_events();
header('Content-Type: application/json');
echo json_encode($events, true);

?>