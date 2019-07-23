<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwshell.inc.php
  Subpackage:   library
  Summary:      Interface for communication with Linux shell
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Checks if given shell command exists and returns boolean.
 */
function CWLIB_shellCommandExists($aCommand)
{
  $path = system("which " . $aCommand . " 2> /dev/null");
  return isset($path) && trim($path) !== "";
}
/* Runs given shell command and returns its output.
 */
function CWLIB_shellCommandRun($aCommand)
{
  return trim(shell_exec($aCommand));
}
/* Adds given files to the cwed.tar archive and returns the operation's
  output. Both given files and the resulting archive are located in the same directory.
  Params include path to the directory, string with basenames of the files separated by space
  and path to the TAR archiver.
 */
function CWLIB_shellExecTar($aTarDir, $aFiles, $aTarPath)
{
  $items = explode(";", $aFiles);
  return CWLIB_shellCommandRun(sprintf("%s cvf %s%scwed.tar -C %s %s 2>&1", $aTarPath, $aTarDir, DIRECTORY_SEPARATOR, $aTarDir, $aFiles));
}
?>
