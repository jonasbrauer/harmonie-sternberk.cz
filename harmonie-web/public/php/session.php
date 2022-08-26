<?php

function get_connection() {
  // Store DB connection details in a plain text config file:
  //----------------------------------------------------------
  //<hostname>
  //<username>
  //<password>
  //<database-name>
  // echo 'reading file...';
  $db_config = "../../data/db.config";
  
  $answer = is_file($db_config);
  if (!file_exists($db_config)) {
    http_response_code(530);
    exit();
  }
  
  $connection_details = file($db_config);
  if (sizeof($connection_details) !== 4) {
    http_response_code(531);
    exit();
  }
  $conn_server = trim($connection_details[0]);
  $conn_user   = trim($connection_details[1]);
  $conn_pass   = trim($connection_details[2]);
  $database    = trim($connection_details[3]);
  
  //mysqli - from PHP 7
  $mysqli = new mysqli ($conn_server,$conn_user,$conn_pass,$database);
  if ($mysqli->connect_errno) {
    http_response_code(503);
    exit();
  }
  return $mysqli;

}

function execute_sql($sql, $connection=null) {
  // Automatically close connection and respond on db errors
  if (!isset($connection)) {
    $connection = get_connection();
  }

  try {
    return $connection->query($sql);

  } catch (Exception $e) {
    http_response_code(402);
    header('Content-Type: application/json');
    echo json_encode($e->getMessage(), true);
    exit();
  
  } finally {
    $connection->close();
  }

}

?>