<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwtar.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to add files to TAR archive
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Adds given files to the cwed.tar archive and returns the operation's
  output. Serves as interface to CW_execTar() function. Params include:
  dirname: param $tarDir of the CW_execTar() function
  files: param $files of the CW_execTar() function
  tarpath: param $tarPath of the CW_execTar() function
 */
function CWAJAX_tarExec()
{
  ob_clean();
  $files = trim(CWLIB_getVarRead('files'));
  $dirName = trim(CWLIB_getVarRead('dirname'));
  $tarPath = trim(CWLIB_getVarRead('tarpath'));
  if (!CWLIB_dirExists($dirName)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_MAKE];
  }
  $startTime = microtime(true);
  $output = CWLIB_shellExecTar($dirName, $files, $tarPath);
  $endTime = microtime(true);
  if (FALSE === $output) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_TAR];
  }
  $lastErr = CWLIB_errorGetLastMsg();
  return sprintf("[Using %s to archive [%s] in [%s]]\n%s%sTime elapsed: %f seconds", $tarPath, $files, $dirName, trim($output) === '' ? '' : $output . '\n', trim($lastErr) === '' ? '' : $lastErr . '\n', $endTime - $startTime);
}
$res = CWAJAX_tarExec();
echo $res;
