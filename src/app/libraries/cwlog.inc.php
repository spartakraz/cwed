<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwlog.inc.php
  Subpackage:   library
  Summary:      logging mechanism
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Wrapper around printf() which appends new-line-char to the output.
 */
function CWLIB_logPrintf()
{
  return call_user_func_array('printf', func_get_args()) + print("\n");
}
/* Writes a message to the web server's error log.
 */
function CWLIB_logError($aMsg)
{
  error_log(sprintf("CWED LOG**: [%s:%d]: %s", basename(__FILE__), __LINE__, $aMsg), 0);
}
/* Outputs given message to the current page with debugging purpose.
 */
function CWLIB_logPrintDebugMsg($aMsg)
{
  if (!is_null($aMsg) && is_string($aMsg) && !empty(trim($aMsg))) {
    echo("<pre>\n");
    var_dump($aMsg);
    echo ('</pre>');
  }
}
/* Prints given object to the current page with the debugging purpose.
 */
function CWLIB_logPrintDebugObject(&$aObj)
{
  if (!is_null($aObj) && is_object($aObj)) {
    echo("<pre>\n");
    if (is_array($aObj)) {
      print_r($aObj);
    } else {
      var_dump($aObj);
    }
    echo ('</pre>');
  }
}
/* Prints a PHP backtrace.
 */
function CWLIB_logPrintBacktrace()
{
  echo("<pre>\n");
  debug_print_backtrace();
  echo ("</pre>");
}
?>
