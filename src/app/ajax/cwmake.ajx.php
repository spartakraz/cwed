<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwmake.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to execute user's makefile
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Runs user's makefile. Params are passed thru $_GET and are as
  follows:
  filename: name of the makefile
  dirname: path to the makefile's directory
  makepath: path to the Make utility
  Returns the program's output
 */
function CWAJAX_makeExec()
{
  ob_clean();
  $fileName = trim(CWLIB_getVarRead('filename'));
  $dirName = trim(CWLIB_getVarRead('dirname'));
  $makePath = trim(CWLIB_getVarRead('makepath'));
  if (!CWLIB_dirExists($dirName)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_MAKE];
  }
  if (!CWLIB_stringEndsWith($fileName, ".mkf")) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_FILE_EXT];
  }
  $startTime = microtime(true);
  $output = CWLIB_makeExecute($dirName, $fileName, $makePath);
  $endTime = microtime(true);
  if (FALSE === $output) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_MAKE];
  }
  $lastErr = CWLIB_errorGetLastMsg();
  return sprintf("[make -f %s -C %s]\n%s%sTime elapsed: %f seconds", $fileName, "<user_dir>", trim($output) === '' ? '' : $output . '\n', trim($lastErr) === '' ? '' : $lastErr . '\n', $endTime - $startTime);
}
$res = CWAJAX_makeExec();
echo $res;
