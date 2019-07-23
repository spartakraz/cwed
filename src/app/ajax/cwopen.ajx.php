<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwopen.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to open a file from user's home dir
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Opens a file from user's home dir. Path to the file is passed thru  variable filepath.
  set in the $_POST superglobal. Returns the operation's status in a string form.
 */
function CWAJAX_fileOpen()
{
  ob_clean();
  $filePath = CWLIB_postVarRead('filepath');
  if (FALSE === CWLIB_fileExists($filePath)) {
    return "";
  }
  $contents = CWLIB_fileRead($filePath) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_OPEN_FILE]);
  return isset($contents) ? $contents : "";
}
$res = CWAJAX_fileOpen();
echo $res;
