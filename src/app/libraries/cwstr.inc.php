<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwstr.inc.php
  Subpackage:   library
  Summary:      string management routines
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Checks if given string variable has a valid value and returns boolean.
 */
function CWLIB_stringIsOk($str)
{
  return !is_null($str) && is_string($str) && !empty($str) && strpos($str, '=') === false;
}
/* Used by the built-in terminal emulator to strip given string of uneccesary chars and
  returns the new stripped version of the string.
 */
function CWLIB_stringOptimize($str)
{
  return preg_replace('/\s+/', ' ', $str);
}
/* Checks if string $haystack starts exactly with substring $needle and returns boolean.
 */
function CWLIB_stringStartsWith($haystack, $needle)
{
  return (substr($haystack, 0, strlen($needle)) === $needle);
}
/* Checks if string $haystack ends exactly with substring $needle and returns boolean.
 */
function CWLIB_stringEndsWith($haystack, $needle)
{
  $length = strlen($needle);
  return $length === 0 ||
          (substr($haystack, -$length) === $needle);
}
/*  Encrypts or decrypts given string depending on the $action. If $action is 'e'
  then the string is encrypted, if 'd' then decrypted. Returns the encrypted or
  decrypted version of the source string.
 */
function CWLIB_stringCrypt($str, $action = 'e')
{
  $secret_key = 'my_simple_secret_key';
  $secret_iv = 'my_simple_secret_iv';
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $key = hash('sha256', $secret_key);
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  if ($action == 'e') {
    $output = base64_encode(openssl_encrypt($str, $encrypt_method, $key, 0, $iv));
  } else if ($action == 'd') {
    $output = openssl_decrypt(base64_decode($str), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}
?>
