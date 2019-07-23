<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwsave.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to save a file from user's home dir
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Saves a file from user's home dir. Path to the file is passed thru variable filename
  set in the $_POST superglobal. Contents of the file is passed thru variable data
  set in the $_POST superglobal. Returns the operation's status in a string form.
 */
function CWAJAX_fileSave()
{
  ob_clean();
  $fileName = CWLIB_postVarRead('filename');
  $data = CWLIB_postVarRead('data');
  if (empty($data)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_SAVE_FILE];
  }
  $retval = CWLIB_fileWrite($fileName, $data, false);
  $msg = ($retval === FALSE) ? sprintf("[Saving %s]\n\n%s\n%s", basename($fileName), $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_SAVE_FILE], CWLIB_errorGetLastMsg()) :
          sprintf("[Saving %s]\n\n%d bytes written", basename($fileName), $retval);
  return $msg;
}
$res = CWAJAX_fileSave();
echo $res;
