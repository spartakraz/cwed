<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwtest.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to run user's program from within the application's environment
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Runs user's program from within the application. Params are passed thru $_GET and are as
  follows:
  execpath: path to the program's executable
  inputfilepath: path to the input file fed to the executable
  inputdata: contents of the input file
  Returns the program's output
 */
function CWAJAX_execfileRun()
{
  ob_clean();
  $outputName = CWLIB_getVarRead('execpath');
  $inputName = CWLIB_getVarRead('inputfilepath');
  $inputdata = CWLIB_getVarRead('inputdata');
  if (!CWLIB_fileExists($outputName)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_EXEC];
  }
  CWLIB_fileWrite($inputName, $inputdata) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_IO]);
  $info = sprintf("Running [%s]\n\n%s", basename($outputName), !CWLIB_fileExists($inputName) ? $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_IO] : CWLIB_execTest($outputName, $inputName));
  return $info;
}
$res = CWAJAX_execfileRun();
echo $res;
