<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwasm.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to compile user's file to assembly
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Compiler user's source file to assembly. Params are passed thru $_GET and are as
  follows:
  srcpath: path to the source file
  asmpath: path to the generated assembly file
  gccpath: path to gcc compiler
  Returns the assembly output.
 */
function CWAJAX_gccGenerateAsm()
{
  ob_clean();
  $srcpath = CWLIB_getVarRead('srcpath');
  $asmpath = CWLIB_getVarRead('asmpath');
  $startTime = microtime(true);
  if (CWLIB_fileExists($asmpath)) {
    CWLIB_fileDrop($asmpath) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_DROP_FILE]);
  }
  $execRes = CWLIB_gccGenerateAsm(
          CWLIB_getVarRead('gcc_path'), $srcpath, $asmpath
  );
  sleep(1);
  if (CWLIB_fileIsReadable($asmpath)) {
    $contents = CWLIB_fileRead($asmpath) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_OPEN_FILE]);
  } else {
    $contents = CWLIB_errorGetLastMsg() ? CWLIB_errorGetLastMsg() : $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_OPEN_FILE];
  }
  return $contents;
}
$res = CWAJAX_gccGenerateAsm();
echo $res;
?>

