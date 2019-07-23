<?php
/* * *
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwlogin.frm.php
  Subpackage:   forms
  Description:  login form
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/** turns on/off the form's debug mode
 */
define('DEBUG_PAGE', false);
if (true === DEBUG_PAGE) {
  if (!defined('E_DEPRECATED')) {
    define('E_DEPRECATED', 8192);
  }
}
/** this flag is used by other forms to check whether or not they are invoked
 * from this login form
 */
define('AUTHENTICATED', true);
/** the includes
 */
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwhtmlclasses.inc.php";
/** bit flags representing Login and Signup submits on the form
 */
const AUTH_LOGIN_SUBMIT_FLAG = 1 << 0;
const AUTH_SIGNUP_SUBMIT_FLAG = 1 << 1;
/** an associative array which stores the form's settings
 */
$authSettings = NULL;
/** the message which the form is to show at the moment to user
 */
$authCurrentMessage = "";
/** handler for the Login submit
 */
function authHandleLoginClicked()
{
  $login = htmlspecialchars(CWLIB_postVarRead('lgn'));
  $pwd = htmlspecialchars(CWLIB_postVarRead('pwd'));

  $isOK = CWLIB_loginStorageCheckLogin($login);
  if (!$isOK) {
    $GLOBALS['authCurrentMessage'] = CWLIB_loginStorageGetLastErrorMessage();
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: authHandleLoginClicked(): invalid login");
    }
    return;
  }
  $isOK = CWLIB_loginStorageCheckPassword($login, $pwd);
  if (!$isOK) {
    $GLOBALS['authCurrentMessage'] = CWLIB_loginStorageGetLastErrorMessage();
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: authHandleLoginClicked(): invalid login or password");
    }
    return;
  }
  CWLIB_sessionVarWrite('cwlogin', $login);
  session_regenerate_id();
  $obres = ob_start();
  include 'cwide.frm.php';
  $obres = ob_end_flush();
  exit;
}
/** handler for the Signup submit
 */
function authHandleSignupClicked()
{
  $login = htmlspecialchars(CWLIB_postVarRead('lgn'));
  $pwd = htmlspecialchars(CWLIB_postVarRead('pwd'));
  if (CWLIB_loginStorageCheckLogin($login)) {
    $GLOBALS['authCurrentMessage'] = CWLIB_loginStorageGetLastErrorMessage();
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: authHandleSignupClicked(): duplicate login");
    }
  } else {
    $res = CWLIB_loginStorageRegisterLogin($login, CWLIB_stringCrypt($pwd, 'e'));
    $GLOBALS['authCurrentMessage'] = $res ? 'Login registered!' : CWLIB_loginStorageGetLastErrorMessage();
    if (!$res && (true === DEBUG_PAGE)) {
      CWLIB_logError("CWED ERROR **: authHandleSignupClicked(): signup failed");
    }
  }
}
/** clears the log file when it becomes too large
 */
function authClearOldLogs()
{
  if (CWLIB_fileExists(CWLIB_LOG_FILE_PATH) && (CWLIB_LOG_FILE_MAX_SIZE <= filesize(CWLIB_LOG_FILE_PATH))) {
    CWLIB_filePutContents(CWLIB_LOG_FILE_PATH, "");
  }
}
/** outputs the form's HTML
 */
function authDrawPage()
{
  echo "<!DOCTYPE html>";
  echo "<html>";
  echo "<head>";
  echo "<title>CWED Account</title>";
  echo "<link rel='stylesheet' href='../../../css/cwlogin.css'>";
  echo "<link rel='icon' href='../../../res/cwed.ico' type='image/x-icon'>";
  echo "<link rel='shortcut icon' href='../../../res/cwed.ico' type='image/x-icon'>";
  echo "</head>";
  echo "<body>";
  echo "<form name='loginForm' method='POST'>";
  echo "<div class='divlogin' align='center'>";
  echo CWLIB_labelGenerateHtml('loginlogos', 'App Title', 'CWED 0.8');
  echo "<p>";
  echo CWLIB_labelGenerateHtml('loginlabels', 'Login', 'Login');
  echo "<br>";
  CWLIB_logPrintf("<input type='text' name='lgn' id='lgn' class='logintexts' title='Your login' value='%s'>", htmlspecialchars(CWLIB_postVarRead('lgn')));
  echo "</p>";
  echo "<p>";
  CWLIB_logPrintf(CWLIB_labelGenerateHtml('loginlabels', 'Password', 'Password'));
  echo "<br>";
  CWLIB_logPrintf("<input type='password' name='pwd' id='pwd' class='logintexts' title='Your password' value='%s'>", htmlspecialchars(CWLIB_postVarRead('pwd')));
  echo "</p>";
  echo "<p>";
  $elem = new CWLIB_Input('submit', 'loginSubmitID', 'loginSubmit', 'loginsubmits', 'Click to log in', 'LOG-IN', '');
  echo $elem->generateHtml();
  $elem = new CWLIB_Input('submit', 'signupSubmitID', 'signupSubmit', 'loginsubmits', 'Click to sign up', 'SIGN-UP', '');
  echo $elem->generateHtml();
  echo "</p>";
  CWLIB_logPrintf(CWLIB_labelGenerateHtml('loginmsgs', 'Diagnostic message for you', isset($GLOBALS['authCurrentMessage']) ? $GLOBALS['authCurrentMessage'] : CWLIB_settingRead($GLOBALS[$authSettings], 'Defaults', 'Message')));
  echo "<br>";
  echo "</div>";
  echo "</form>";
  echo "</body>";
  echo "</html>";
}
/** initializes this script
 */
function authInit()
{
  error_reporting((true === DEBUG_PAGE) ? (E_ALL | E_STRICT) : 0);
  ini_set('display_errors', (true === DEBUG_PAGE) ? 1 : 0);
  ini_set('display_startup_errors', (true === DEBUG_PAGE) ? 1 : 0);
  if ((true === DEBUG_PAGE)) {
    ini_set('log_errors', 'On');
    ini_set('error_log', CWLIB_LOG_FILE_PATH);
  }
  if (false === strpos(strtoupper(PHP_OS), 'LINUX')) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: authInit(): The application's library works only under Linux!");
    }
    die("The application's library works only under Linux!");
  }
  if (version_compare(PHP_VERSION, '5.6.0', 'lt')) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: authInit(): PHP 5.6+ is required");
    }
    die('PHP 5.6+ is required');
  }
  $GLOBALS['authSettings'] = array();
  CWLIB_settingWrite($GLOBALS['authSettings'], 'Defaults', 'Login', 'root');
  CWLIB_settingWrite($GLOBALS['authSettings'], 'Defaults', 'Password', 'rootkey');
  CWLIB_settingWrite($GLOBALS['authSettings'], 'Defaults', 'Message', 'Please, log in or sign up');
  $GLOBALS['authCurrentMessage'] = CWLIB_settingRead($GLOBALS['authSettings'], 'Defaults', 'Message');
  if (CWLIB_sessionVarIsset('cwlogin')) {
    CWLIB_sessionVarUnset('cwlogin');
  }
  if (!file_exists(CWLIB_LOGIN_STORAGE_PATH) ||
          !is_readable(CWLIB_LOGIN_STORAGE_PATH) ||
          !is_writable(CWLIB_LOGIN_STORAGE_PATH)) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: authInit(): " . CWLIB_settingRead($GLOBALS['authSettings'], 'Errors', 'LoginStorageError'));
    }
    die(CWLIB_settingRead($GLOBALS['authSettings'], 'Errors', 'LoginStorageError'));
  }
  CWLIB_loginStorageInit();
  authClearOldLogs();
  return true;
}
/** returns a word with a bit flag set indicating which submit
 * was clicked
 */
function authGetSubmitType()
{
  $submitType = 0;
  if (CWLIB_submitClicked('loginSubmit')) {
    $submitType |= AUTH_LOGIN_SUBMIT_FLAG;
  }
  if (CWLIB_submitClicked('signupSubmit')) {
    $submitType |= AUTH_SIGNUP_SUBMIT_FLAG;
  }
  return $submitType;
}
/** the script's entry point
 */
function authMain()
{
  if (PHP_SESSION_NONE === session_status()) {
    session_start();
  }
  authInit() or die('Initialization error!');
  $currentSubmit = authGetSubmitType();
  if ($currentSubmit & AUTH_LOGIN_SUBMIT_FLAG) {
    authHandleLoginClicked();
  } else if ($currentSubmit & AUTH_SIGNUP_SUBMIT_FLAG) {
    authHandleSignupClicked();
  } else {
    $GLOBALS['authCurrentMessage'] = CWLIB_settingRead($GLOBALS['authSettings'], 'Defaults', 'Message');
  }
  authDrawPage();
}
authMain();
?>
