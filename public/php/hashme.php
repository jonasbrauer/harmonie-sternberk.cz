<?php

// Utility: create password hashes

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit();
}
$_POST = json_decode(file_get_contents('php://input'), true);
$text = $_POST['text'];
$hash = password_hash($text, PASSWORD_DEFAULT, ['cost' => 10]);

echo $hash;

?>