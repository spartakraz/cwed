<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwdrop.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to delete a file from user's home dir
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Drops a file from user's home dir. Path to the file is passed thru  variable filepath.
  set in the $_GET superglobal. Returns the operation's status in a string form.
 */
function CWAJAX_fileDrop()
{
  $path = trim(CWLIB_getVarRead('filepath'));
  if (!CWLIB_fileExists($path)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_DROP_FILE];
  }
  $res = CWLIB_fileIsRegular($path) ? CWLIB_fileDrop($path) : CWLIB_dirDrop($path);
  return $res ? "File/directory deleted successfully" : $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_DROP_FILE];
}
$res = CWAJAX_fileDrop();
echo $res;
