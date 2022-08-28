<?php

function validateUsername($mysqli, $string) {
  if (isset($string) && !strrpos($string, '@')) {
    return mysqli_real_escape_string($mysqli, $string);
  }
  return null;
}

function validateEmail($mysqli, $string) {
  if (isset($string) && strrpos($string, '@') !== -1) {
    return mysqli_real_escape_string($mysqli, $string);
  }
  return null;
}

?>