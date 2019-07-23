<?php
/* * *
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwterm.frm.php
  Subpackage:   forms
  Description:  terminal emulator (console) for testing user's program
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwproc.inc.php";
/** Shows where the program's output begins.
 */
define('START_DELIMETER', "STARTING---------");
/** Shows where the program's output ends.
 */
define('END_DELIMETER', "$$$$$*******----EXITING CWTERM----*******$$$$$");
/** This class is responsible for organizing communication between the console
 * and the process (i.e. the user's program). Uses special input buffer for
 * storing user's commands and input data.
 */
class CW_Term
{
  // Delay in ms between IO interactions with the process.
  const SLEEP_LEN = 40000;
  // shell to be used by the console
  const SHELL_PATH = "/bin/bash";
  // Instance of this class
  private static $instance;
  // In-memory storage where the input buffer's contents are written to before
  // becoming available to the class.
  private static $inputData;
  // Number of items found in the in-memory storage
  private static $inputCount;
  // indicates whether or not the process has finished.
  private static $isFinished;
  // The process
  private $process;
  // Info about the status of the process in an array form
  private $status;
  // The process-related metadata in an array form
  private $metadata;
  // The program's path
  private $command;
  // The program's working directory
  private $workDir;
  // Checks whether or not the input buffer is writable and returns boolean.
  private function checkBuffer()
  {
    return CWLIB_fileIsWritable(CWLIB_cookieVarRead('buffer'));
  }
  // Clears the input buffer of all data left after previous sessions.
  private function clearBuffer()
  {
    CWLIB_filePutContents(CWLIB_cookieVarRead('buffer'), "");
  }
  // Updates the contents of the in-memory storage
  private function synchronizeBuffer()
  {
    self::$inputData = file(CWLIB_cookieVarRead('buffer'));
  }
  // Skips those parts of the process's output that are not supposed to be
  // displayed to the user.
  private function skipNonprintableData()
  {
    $this->process->readFrom();
  }
  // Analyzes the process's output to determine whether or not
  // the program is currently waiting for the user's input.
  // Returns boolean.
  private function waitingForInput(&$output)
  {
    return (sizeof($output) == 1 && ord($output) == 0);
  }
  // Here we spawn the process and throw a fatal exception if
  // the operation fails.
  private function spawnShell()
  {
    $this->process = new CWLIB_Process(self::SHELL_PATH, $this->workDir);
    if (!$this->process->isResource()) {
      throw new Exception("RESOURCE NOT AVAIBLE");
    }
  }
  // initializes the loop which starts the process and establishes its
  // interaction with the user
  private function startTheLoop()
  {
    // we stop immediately if we cannot write to the buffer
    if (!$this->checkBuffer()) {
      $errmsg = "\r\nNeed permission to write in " . CWLIB_sessionVarRead('buffer') . "\r\n";
      $this->sendOutput($errmsg);
      return false;
    }
    $this->clearBuffer();
    self::$isFinished = false;
    $this->spawnShell();
    usleep(self::SLEEP_LEN);
    $this->skipNonprintableData();
    usleep(self::SLEEP_LEN);
    self::appendToBuffer($this->command);
    do {
      $output = $this->process->readFrom();
      if ($this->waitingForInput($output)) {
        $this->feedInput();
      }
      $this->sendOutput($output);
      usleep(self::SLEEP_LEN);
      $this->status = $this->process->getStatus();
      $this->metadata = $this->process->getMetadata();
    } while ($this->metadata['eof'] === false);
    $this->process->close();
    return true;
  }
  // Strips the program's output of those parts which
  // are not related to the program's output.
  private function truncateOutput(&$output)
  {
    if ((1 === self::$inputCount)) {
      $start = strpos($output, START_DELIMETER);
      if (FALSE !== $start) {
        $output = substr($output, $start);
      }
    }
    $end = strpos($output, END_DELIMETER);
    if (FALSE !== $end) {
      $output = substr($output, 0, $end + strlen(END_DELIMETER));
      self::$isFinished = true;
    }
  }
  // Sends the program's output to the console
  private function sendOutput(&$output)
  {
    $this->truncateOutput($output);
    $output = preg_replace("/\r\n|\r|\n/", '\n', 
            sprintf("<span>%s</span>", implode("</span><span>", 
                    explode("\n", addslashes(htmlentities($output))))));
    echo "<script>TERM_receiver(\"{$output}\");</script>\n";
    flush();
    $end = strpos($output, END_DELIMETER);
    if (FALSE !== $end) {
      echo "<script>TERM_receiver(\":q\");</script>\n";
    }
    return $output;
  }
  // Reads the user's last input from the input buffer.
  // Returns either the input or NULL in the case of error.
  private function obtainInput()
  {
    $this->synchronizeBuffer();
    if (sizeof(self::$inputData) > self::$inputCount) {
      self::$inputCount = sizeof(self::$inputData);
      $lastItem = trim(self::$inputData[self::$inputCount - 1]);
      return $lastItem;
    } else {
      return NULL;
    }
  }
  // Feeds the user's input to the process
  private function feedInput()
  {
    $lastItem = $this->obtainInput();
    if (!is_null($lastItem)) {
      $this->process->writeTo(chr(21));
      $this->process->writeTo($lastItem);
      $this->process->writeTo("\n");
      usleep(self::SLEEP_LEN);
    }
  }
  public static function isFinished()
  {
    return self::$isFinished;
  }
  // Appends user's input to the input buffer.
  public static function appendToBuffer($item)
  {
    CWLIB_filePutContentsAppend(CWLIB_cookieVarRead('buffer'), $item . "\n");
  }
  //  Factory class for creating an instance of the class. Params include
  //  the program's working directory and path.
  public static function factory($aWorkDir, $aCommand)
  {
    self::$instance = new self();
    self::$instance->setWorkDir($aWorkDir);
    self::$instance->setCommand($aCommand);
    return self::$instance->startTheLoop();
  }
  // sets the program working directory
  public function setWorkDir($dirName)
  {
    $this->workDir = $dirName;
  }
  // sets the program's path
  public function setCommand($aCommand)
  {
    $this->command = $aCommand;
  }
}
/** initializes this module
 */
function CW_Term_Init()
{
  // We are doing this because the program's execution can take a long time.
  set_time_limit(0);
  // param dirname is path to user's personal (home) directory
  if (CWLIB_getVarIsset('dirname')) {
    CWLIB_cookieVarWrite('dirname', urldecode(CWLIB_getVarRead('dirname'))); //
  }
  // param execname is the program's basename
  if (CWLIB_getVarIsset('execname')) {
    CWLIB_cookieVarWrite('execname', urldecode(CWLIB_getVarRead('execname')));
  }
  // param execpath is program's path
  CWLIB_cookieVarWrite('execpath', CWLIB_cookieVarRead('dirname') . DIRECTORY_SEPARATOR . CWLIB_cookieVarRead('execname'));
  // making sure that the console halts if the path is invalid.
  CWLIB_fileExists(CWLIB_cookieVarRead('execpath')) || die("Executable not found");
  // param buffer specifies the input buffer's location
  CWLIB_cookieVarWrite('buffer', CWLIB_cookieVarRead('dirname') . DIRECTORY_SEPARATOR . "buffer.asc");
  // Here we create the input buffer if it doesn't exist yet
  if (!CWLIB_fileExists(CWLIB_cookieVarRead('buffer'))) {
    $fp = fopen(CWLIB_cookieVarRead('buffer'), 'w');
    fwrite($fp, "");
    fclose($fp);
  }
}
/** outputs HTML for this module
 */
function CW_Term_Build_Page()
{

  $html = <<<EOHTML
<html>
    <head>
        <title>cwterm</title>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'></script>
        <script src='../../../js/app/cwterm.js'></script>
        <link rel='stylesheet' href='../../../css/cwterm.css'>
    </head>
    <body>
        <div class='divtitle' align='center'>
            CWED TERMINAL
        </div>
        <br>
        <pre><label class="stdout"></label></pre>
        <label for='stdin'>stdin:</label>
        <input type="text" name="stdin" id='stdin' class="stdin" autocomplete="off" />
    </body>
    <script type="text/javascript">
        term_init();
   </script>
</html>
EOHTML;

  echo $html;
}
/** We don't want the console to run the program directly - instead here we create
 * a batch file telling the shell how to accomplish this task. Param is path
 * to this batch file.
 */
function CW_Term_Prepare_Script($batchFile)
{
  if (!CWLIB_fileExists($batchFile)) {
    $fp = fopen($batchFile, 'w');
    fwrite($fp, "#!/bin/bash");
    fclose($fp);
    chmod($batchFile, 0777);
  }
  // here we specify the file's lines
  $lines = array("echo '" . START_DELIMETER . "'\n",
      "echo \n", CWLIB_cookieVarRead('execpath') . "\n",
      "echo \n", "echo 'Press ENTER to continue'\n",
      "read _\n",
      "echo '" . END_DELIMETER . "'\n"
  );
  // to make sure the previous content is cleared
  CWLIB_filePutContents($batchFile, "");
  CWLIB_filePutContentsAppendArray($batchFile, $lines);
}
/** the module's entry point
 */
function CW_Term_Main()
{
  CW_Term_Init();
  // if user has entered sth in the console's input area
  if (CWLIB_postVarIsset('stdin')) {
    $cmd = strtolower(trim(CWLIB_postVarRead('stdin')));
    CW_Term::appendToBuffer($cmd);
    exit; // to prevent creation of a new instance of the console to handle the input
  }
  header("Content-type: text/html; charset=utf8");
  $batchFile = CWLIB_cookieVarRead('buffer') . ".sh";
  CW_Term_Prepare_Script($batchFile);
  CW_Term_Build_Page();
  CW_Term::factory(sys_get_temp_dir(), $batchFile);
}
CW_Term_Main();
?>