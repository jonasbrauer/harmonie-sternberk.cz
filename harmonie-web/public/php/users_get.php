<?php

// Only admins can query user information
include 'require_admin.php';

/**
 *   USER
 *   any login-able user (member or admin)
 * ---------------------------------------------------------
 *
 */

function get_users() {
  $connection = get_connection();
  $sql = "SELECT id, username,role, email, validated FROM users;";
  try {
    $result = $connection->query($sql);
  } catch (Exception $e) {
    return array();
  }
  $connection->close();

  $events = array();
  while($row = $result->fetch_assoc()) {
    $row['validated'] = (bool) $row['validated'];
    $events[] = $row;
  }
  return $events;
}

$users = get_users();
header('Content-Type: application/json');
echo json_encode($users, true);

?>