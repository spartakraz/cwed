<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwdelproj.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to delete project's directory
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Deletes project's directory and returns status of the operation in a string form.
  The function requires  param  filepath set in the $_GET superglobal to store
  path to the directory.
 */
function CWAJAX_projectDrop()
{
  $path = trim(CWLIB_getVarRead('filepath'));
  if (!CWLIB_fileExists($path) || CWLIB_fileIsRegular($path)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_DROP_FILE];
  }
  $res = CWLIB_dirDrop($path);
  return $res ? "Directory deleted successfully" : $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_DROP_FILE];
}
$res = CWAJAX_projectDrop();
echo $res;
