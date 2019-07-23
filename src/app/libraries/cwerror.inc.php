<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwerror.inc.php
  Subpackage:   library
  Summary:      custom error-handling routines
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/*
  Returns message of the last error occured within the application.
 */
function CWLIB_errorGetLastMsg()
{
  $error = error_get_last();
  return isset($error) ? $error["message"] : "";
}
/*
  Throws a fatal error with given message. Returns boolean indicating whether or not the error
  was thrown successfully.
 */
function CWLIB_errorThrowFatal($aMsg)
{
  if (is_null($aMsg) || !is_string($aMsg)) {
    $aMsg = "The library fatal error!";
  }
  error_log($aMsg, 0);
  return trigger_error($aMsg, E_USER_ERROR);
}
/*
  Callback for set_error_handler().
 */
function CWLIB_errorCallback($aErrNo, $aErrStr, $aErrFile, $aErrLine)
{
  if (!(error_reporting() & $aErrNo)) {
    return;
  }
  switch ($aErrNo) {
    case E_USER_ERROR:
      echo "<b>The library's error***: </b> [$aErrFile]:[$aErrLine] [$aErrNo] $aErrStr<br>\n";
      CWLIB_logPrintBacktrace();
      exit(1);
      break;
    case E_USER_WARNING:
      echo "<b>The library's warning***: </b> [$aErrFile]:[$aErrLine] [$aErrNo] $aErrStr<br>\n";
      break;
    case E_USER_NOTICE:
      echo "<b>The library's notice***: </b> [$aErrFile]:[$aErrLine] [$aErrNo] $aErrStr<br>\n";
      break;
    default:
      echo "<b>The library's unknown error***: </b> [$aErrFile]:[$aErrLine] [$aErrNo] $aErrStr<br>\n";
      break;
  }
  return true;
}
/*
  Callback for set_exception_handler().
 */
function CWLIB_exceptionCallback($aExc)
{
  $isException = !is_null($aExc) && is_object($aExc) && ($aExc instanceof Exception);
  $msg = $isException ? $aExc->getMessage() : 'The library internal error!';
  echo "The library's Exception***: ", $msg, "\n Aborting...\n\n";
  error_log($msg);
  if ($isException) {
    CWLIB_logPrintDebugObject($aExc);
  } else {
    CWLIB_logPrintDebugMsg($msg);
  }
}
?>
