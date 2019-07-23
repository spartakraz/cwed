<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwlint.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to check the syntax of user's file
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Checks the syntax of user's source file. Params are passed thru $_GET and are as
  follows:
  srcpath: path to the source file
  gccpath: path to gcc compiler
  Returns the compiler's output
 */
function CWAJAX_gccLint()
{
  ob_clean();
  $srcpath = CWLIB_getVarRead('srcpath');
  $startTime = microtime(true);
  $execRes = CWLIB_gccCheckSyntax(CWLIB_getVarRead('gcc_path'), $srcpath);
  $endTime = microtime(true);
  $lastErr = CWLIB_errorGetLastMsg();
  $info = sprintf("%s%sTime elapsed: %f seconds", trim($execRes) === "" ? "" : $execRes . "\n", trim($lastErr) === "" ? "" : $lastErr . "\n", $endTime - $startTime);
  return $info;
}
$res = CWAJAX_gccLint();
echo $res;
?>
