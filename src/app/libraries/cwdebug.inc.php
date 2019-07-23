<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwdebug.inc.php
  Subpackage:   library
  Summary:      functions used for testing and debugging user programs
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('DEBUG_PAGE')) {
  define('DEBUG_PAGE', false);
}
/*
  Compiles given source file to machine code. Params include path to the gcc compiler,
  compilation options, path to the source file and path to the generated
  executable. Returns the compiler's output.
 */
function CWLIB_gccInvoke($aGccExec, $aGccOptions, $aSourceFile, $aOutputFile)
{
  $output = CWLIB_shellCommandRun(sprintf("%s %s %s -o %s  2>&1", $aGccExec, $aGccOptions, $aSourceFile, $aOutputFile));
  if (!DEBUG_PAGE) {
    $output = str_replace(CWLIB_USER_DIR_PATH, "<user_dir>", $output);
  }
  return $output;
}
/*
  Compiles given source file to assembly. Params include path to the gcc compiler,
  path to the source file and path to the generated asm file. Returns the compiler's output.
 */
function CWLIB_gccGenerateAsm($aGccExec, $aSourceFile, $aOutputFile)
{
  return CWLIB_shellCommandRun(sprintf("%s -S %s -o %s  2>&1", $aGccExec, $aSourceFile, $aOutputFile));
}
/*
  Checks the syntax of a given source file. Params include path to the gcc compiler and
  path to the source file. Returns the compiler's output.
 */
function CWLIB_gccCheckSyntax($aGccExec, $aSourceFile)
{
  $output = CWLIB_shellCommandRun(sprintf("%s -fsyntax-only %s  2>&1", $aGccExec, $aSourceFile));
  if (!DEBUG_PAGE) {
    $output = str_replace(CWLIB_USER_DIR_PATH, "<user_dir>", $output);
  }
  return $output;
}
/*
  Debugs given program with the BACKTRACE command. Params include path to the gdb debugger,
  path to the program's executable, path to the input file fed to the executable and
  path to the batch file listing the commands for the debugger. Returns the debugger's output.
 */
function CWLIB_gdbInvoke($aGdbExec, $aTestExec, $aInputFile, $aBatchFileName)
{
  $output = !CWLIB_fileWrite($aBatchFileName, sprintf("run < %s\nbacktrace\nquit\n", $aInputFile)) ?
          "Failed to create a batch file for the debugger!" :
          CWLIB_shellCommandRun(sprintf("%s %s --batch -x %s 2>&1", $aGdbExec, $aTestExec, $aBatchFileName));
  if (!DEBUG_PAGE) {
    $output = str_replace(CWLIB_USER_DIR_PATH, "<user_dir>", $output);
  }
  return $output;
}
/*
  Executes a makefile. Params include path to makefile's directory, basename of the makefile itself,
  and path to the Make utility. Returns output of the Make utility.
 */
function CWLIB_makeExecute($aMakeDir, $aMakeFile, $aMakePath)
{
  $output = CWLIB_shellCommandRun($aMakePath . " --directory={$aMakeDir} --file={$aMakeFile} 2>&1");
  if (!DEBUG_PAGE) {
    $output = str_replace($aMakeDir, "<user_dir>", $output);
  }
  return $output;
}
/*
  Runs user's program from within the application. Params include path to the program's
  executable and path to the input file fed to the program. Returns the program's output.
 */
function CWLIB_execTest($aExecFile, $aInputFile = null)
{
  $cmd = (null === $aInputFile) ? sprintf("%s 2>&1", $aExecFile) : sprintf("%s < %s 2>&1", $aExecFile, $aInputFile);
  return sprintf("%s\n\n%s", CWLIB_shellCommandRun($cmd), is_null($aInputFile) ? 'No input data used' : 'Using input data');
}
