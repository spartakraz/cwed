<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwsuperglob.inc.php
  Subpackage:   library
  Summary:      interface for accessing PHP's superglobal arrays
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/*  Checks if a variable is set in a superglobal array. The superglobal is specified by turning on
  its bit flag (see CWLIB_HTTP_Vars_Enum) in $aFlags. Name of the variable is specified in $aName.
  Returns boolean.
 */
function CWLIB_superGlobalVarIsset($aFlags, $aName)
{
  if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS) {
    $retValue = isset($_POST[$aName]);
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS) {
    $retValue = isset($_GET[$aName]);
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS) {
    $retValue = isset($_SERVER[$aName]);
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS) {
    $retValue = isset($_SESSION[$aName]);
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS) {
    $retValue = isset($_COOKIE[$aName]);
  } else {
    $retValue = isset($_POST[$aName]);
  }
  return $retValue;
}
/*  Reads value of a variable set in a superglobal array. The superglobal is specified by turning on
  its bit flag (see CWLIB_HTTP_Vars_Enum) in $aFlags. Name of the variable is specified in $aName.
  Returns string value or NULL if the variable is not set.
 */
function CWLIB_superGlobalVarRead($aFlags, $aName)
{
  if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS) {
    $retValue = $_POST[$aName];
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS) {
    $retValue = $_GET[$aName];
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS) {
    $retValue = $_SERVER[$aName];
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS) {
    $retValue = $_SESSION[$aName];
  } else if (($aFlags & CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS) === CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS) {
    $retValue = $_COOKIE[$aName];
  } else {
    $retValue = $_POST[$aName];
  }
  return $retValue;
}
/* Checks if a variable with given name is set in the $_COOKIE superglobal.
 */
function CWLIB_cookieVarIsset($aName)
{
  return CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS, $aName);
}
/* Reads value of a variable with given name set in the $_COOKIE superglobal.
 */
function CWLIB_cookieVarRead($aName)
{
  return !CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS, $aName) ? NULL : CWLIB_superGlobalVarRead(CWLIB_HTTP_Vars_Enum::CWLIB_COOKIE_VARS, $aName);
}
/* Assigns new value to a variable with given name set in the $_COOKIE superglobal.
 */
function CWLIB_cookieVarWrite($aName, $aValue)
{
  setcookie($aName, $aValue, time() + 60 * 60 * 24 * 365, '/');
  $_COOKIE[$aName] = $aValue;
}
/* Checks if a variable with given name is set in the $_POST superglobal.
 */
function CWLIB_postVarIsset($aName)
{
  return CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS, $aName);
}
/* Reads value of a variable with given name set in the $_POST superglobal.
 */
function CWLIB_postVarRead($aName)
{
  return !CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS, $aName) ? NULL : CWLIB_superGlobalVarRead(CWLIB_HTTP_Vars_Enum::CWLIB_POST_VARS, $aName);
}
/* Checks if a variable with given name is set in the $_GET superglobal.
 */
function CWLIB_getVarIsset($aName)
{
  return CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS, $aName);
}
/* Reads value of a variable with given name set in the $_GET superglobal.
 */
function CWLIB_getVarRead($aName)
{
  return !CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS, $aName) ? NULL : CWLIB_superGlobalVarRead(CWLIB_HTTP_Vars_Enum::CWLIB_GET_VARS, $aName);
}
/* Checks if a variable with given name is set in the $_SERVER superglobal.
 */
function CWLIB_serverVarIsset($aName)
{
  return CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS, $aName);
}
/* Reads value of a variable with given name set in the $_SERVER superglobal.
 */
function CWLIB_serverVarRead($aName)
{
  return !CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS, $aName) ? NULL : CWLIB_superGlobalVarRead(CWLIB_HTTP_Vars_Enum::CWLIB_SERVER_VARS, $aName);
}
/* Checks if a variable with given name is set in the $_SESSION superglobal.
 */
function CWLIB_sessionVarIsset($aName)
{
  return CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS, $aName);
}
/* Reads value of a variable with given name set in the $_SESSION superglobal.
 */
function CWLIB_sessionVarRead($aName)
{
  return !CWLIB_superGlobalVarIsset(CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS, $aName) ? NULL : CWLIB_superGlobalVarRead(CWLIB_HTTP_Vars_Enum::CWLIB_SESSION_VARS, $aName);
}
/* Assigns new value to a variable with given name set in the $_SESSION superglobal.
 */
function CWLIB_sessionVarWrite($aName, $aValue)
{
  $_SESSION[$aName] = $aValue;
}
/* Unsets variable with given name set in the $_SESSION superglobal.
 */
function CWLIB_sessionVarUnset($aName)
{
  if (CWLIB_sessionVarIsset($aName)) {
    $_SESSION[$aName] = null;
    unset($_SESSION[$aName]);
  }
}
/* Checks if submit button with given name was clicked and
 * returns boolean.
 */
function CWLIB_submitClicked($aName)
{
  return CWLIB_postVarIsset($aName);
}
?>
