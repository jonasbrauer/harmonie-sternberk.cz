<?php

include 'auth.php';

/**
 * 
 * AUTH SCRIPT
 *
 * logs users out - only on DELETE
 * validates session cookie - if present
 * logs users in and sends auth session cookie
 * 
 * Blocks invalid input, no output on success. 
 * 
*/
logout();
$username = validate_cookie();

if( !isset($username) ) {
  $username = login_post();
}
$user = get_user($username);

header('Content-Type: application/json');

unset($user['password']);
echo json_encode($user, true);

?>