<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwdebug.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to debug user's program with the backtrace command
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Debugs user's program with the backtrace command. Params are passed thru $_GET and are as
  follows:
  gdbpath: path to gdb debugger
  execptah: path to the program's executable file
  inputname: path to the input file fed to the executable
  inputdata: contents of the input file
  batchname: path to the batch file listing the commands for the debugger
  Returns the debugger's output
 */
function CWAJAX_gdbBacktrace()
{
  $gdbpath = CWLIB_getVarRead('gdbpath');
  $execpath = CWLIB_getVarRead('execpath');
  $inputname = CWLIB_getVarRead('inputname');
  $batchname = CWLIB_getVarRead('batchname');
  $inputdata = CWLIB_getVarRead('inputdata');
  if (!CWLIB_shellCommandExists($gdbpath)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_SHELLCMD];
  }
  if (!CWLIB_fileExists($execpath)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_EXEC];
  }
  CWLIB_fileWrite($inputname, $inputdata) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_IO]);
  $msg = sprintf("Debugging %s\n%s", basename($execpath), CWLIB_gdbInvoke($gdbpath, $execpath, $inputname, $batchname));
  return $msg;
}
$res = CWAJAX_gdbBacktrace();
echo $res;
