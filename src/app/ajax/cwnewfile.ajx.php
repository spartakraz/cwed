<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwnewfile.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to create a file in user's home dir
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Creates a file in user's home dir. Path to the file is passed thru  variable filepath.
  set in the $_POST superglobal. Returns the operation's status in a string form.
 */
function CWAJAX_fileCreate()
{
  ob_clean();
  $filePath = CWLIB_postVarRead('filepath');
  if (FALSE === CWLIB_fileExists($filePath)) {
    CWLIB_fileWrite($filePath, CWLIB_DEFAULT_EDITOR_CONTENTS, false) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CREATE_FILE]);
  } else {
    return "";
  }
  $contents = CWLIB_fileRead($filePath) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CREATE_FILE]);
  return isset($contents) ? $contents : "";
}
$res = CWAJAX_fileCreate();
echo $res;
