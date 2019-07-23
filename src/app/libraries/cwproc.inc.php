<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwproc.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Encapsulates a process running in the built-in terminal emulator.
 */
class CWLIB_Process
{
  /* a resource representing the process
   */
  private $mProcess;
  /* an array of pipes the process will read from and write to
   */
  private $mPipes;
  /* Default constructor. Params include the command to execute and
    initial working directory for the command.
   */
  public function __construct($aCommand, $aWorkDir)
  {
    $this->open($aCommand, $aWorkDir);
  }
  /* Default destructor.
   */
  public function __destruct()
  {
    $this->close();
  }
  /* Starts the process. Params are the same as constructor's.
   */
  public function open($aCommand, $aWorkDir)
  {
    $spec = array(
        0 => array("pty"),
        1 => array("pty"),
        2 => array("pty")
    );
    $this->mProcess = proc_open($aCommand, $spec, $this->mPipes, $aWorkDir);
    $this->setBlocking(0);
  }
  /* Checks if the process's resource is valid and returns boolean.
   */
  public function isResource()
  {
    return is_resource($this->mProcess);
  }
  /* Checks if the process is currently running and returns boolean.
   */
  public function isRunning()
  {
    $status = proc_get_status($this->mProcess);
    return (true === $status['running']);
  }
  /* Sets blocking or non-blocking mode on the output pipe and returns boolean.
   */
  public function setBlocking($blocking = 1)
  {
    return stream_set_blocking($this->mPipes[1], $blocking);
  }
  /* Reads from the process's output.
   */
  public function readFrom()
  {
    $out = stream_get_contents($this->mPipes[1]);
    return $out;
  }
  /* Writes data to the process's input.
   */
  public function writeTo($aData)
  {
    fwrite($this->mPipes[1], $aData);
    fflush($this->mPipes[1]);
  }
  /* Closes the process and all opened file descriptors.
   */
  public function close()
  {
    if (is_resource($this->mProcess)) {
      fclose($this->mPipes[0]);
      fclose($this->mPipes[1]);
      fclose($this->mPipes[2]);
      return proc_close($this->mProcess);
    }
  }
  /* Returns an array with the status information about the current process.
   */
  public function getStatus()
  {
    return proc_get_status($this->mProcess);
  }
  /* Returns an array with the process metadata.
   */
  public function getMetadata()
  {
    return stream_get_meta_data($this->mPipes[1]);
  }
}
?>
