<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwviewdir.ajx.php
  Subpackage:   ajax
  Summary:      invoked by ajax requests to return the contents of user's home dir
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Returns the contents of user's home dir. Path to the home dir
  is passed thru $_GET in variable dirname.
 */
function CWAJAX_dirViewContents()
{
  ob_clean();
  $dirName = CWLIB_getVarRead('dirname');
  $list = CWLIB_dirGetList($dirName);
  sort($list);
  return implode(":", $list);
}
$res = CWAJAX_dirViewContents();
echo $res;
