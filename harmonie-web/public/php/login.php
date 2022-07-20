<?php

include 'auth.php';

$user = get_user($username);

header('Content-Type: application/json');
unset($user['password']);
echo json_encode($user, true);

?>