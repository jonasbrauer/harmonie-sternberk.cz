<?php

include 'auth.php';

$username = validate_cookie();

$user = get_user($username);
if ($user['role'] !== 'admin') {
  http_response_code(403);
  exit();
}

?>