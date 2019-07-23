<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwcompile.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to compile user's file
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/* Compiler user's source file to assembly. Params are passed thru $_GET and are as
  follows:
  srcpath: path to the source file
  execpath: path to the generated assembly file
  gccpath: path to gcc compiler
  main_options: compilation options
  Returns the compiler's output.
 */
function CWAJAX_gccCompile()
{
  ob_clean();
  $srcpath = CWLIB_getVarRead('srcpath');
  if (!CWLIB_fileExists($srcpath)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_IO];
  }
  if (!CWLIB_shellCommandExists(CWLIB_getVarRead('gcc_path'))) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_SHELLCMD];
  }
  $gccOptions = trim(CWLIB_getVarRead('main_options'));
  $startTime = microtime(true);
  $execRes = CWLIB_gccInvoke(CWLIB_getVarRead('gcc_path'), $gccOptions, $srcpath, CWLIB_getVarRead('execpath'));
  $endTime = microtime(true);
  $lastErr = CWLIB_errorGetLastMsg();
  $info = sprintf("[%s]\n%s%sTime elapsed: %f seconds", $gccOptions, trim($execRes) === "" ? "" : $execRes . "\n", trim($lastErr) === "" ? "" : $lastErr . "\n", $endTime - $startTime);
  return $info;
}
$res = CWAJAX_gccCompile();
echo $res;
