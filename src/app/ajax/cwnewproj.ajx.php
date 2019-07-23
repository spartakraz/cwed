<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwnewproj.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to create directory for a new project
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/*  Creates a directory for a new project and returns status of the operation in a string form.
  The function requires two params passed thru the $_GET superglobal:
  project_name: name of the project
  dirpath: user's home directory where the project will be created
 */
function CWAJAX_projectCreate()
{
  ob_clean();
  $projectName = CWLIB_postVarRead('project_name');
  $dirPath = CWLIB_postVarRead('dirpath') . DIRECTORY_SEPARATOR . $projectName;
  $filePath = CWLIB_postVarRead('dirpath') . DIRECTORY_SEPARATOR . $projectName . ".mkf";
  if (TRUE === CWLIB_dirExists($dirPath)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CREATE_FILE];
  }
  CWLIB_dirMake($dirPath) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CREATE_FILE]);
  if (TRUE === CWLIB_fileExists($filePath)) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CREATE_FILE];
  }
  CWLIB_fileWrite($filePath, "# makefile for a project {$projectName}", false) or die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CREATE_FILE]);
  return CWLIB_DEFAULT_IDE_MSG;
}
$res = CWAJAX_projectCreate();
echo $res;
