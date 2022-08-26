<?php

include 'auth.php';

$username = validate_cookie();

$user = get_user($username);
if ($user['role'] !== 'admin' && $user['role'] !== 'member') {
  http_response_code(403);
  exit();
}

?>