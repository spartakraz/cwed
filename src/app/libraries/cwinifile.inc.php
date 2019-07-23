<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwinifile.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* interface to accessing the application's ini file
 */
class CWLIB_IniFile
{
  /* path to the file
   */
  private $mFileName;
  /* contents of the file
   */
  private $mContents;
  /* Default constructor. Param is the path to the file.
   */
  function __construct($aFileName)
  {
    $this->setFileName($aFileName);
    $this->mContents = parse_ini_file($this->mFileName);
    if (!$this->mContents) {
      throw new Exception("Initialization error");
    }
  }
  /* sets path to the file
   */
  public function setFileName($aFileName)
  {
    $this->mFileName = $aFileName;
  }
  /*  returns value of the parameter with given name, or given default value
    if the parameter has not been found
   */
  public function readParameter($aName, $aDefaultVal)
  {
    return isset($this->mContents[$aName]) ? $this->mContents[$aName] : $aDefaultVal;
  }
}
/* helper factory method for creating an instance of the CWLIB_IniFile class */
function CWLIB_iniFileFactory($aFileName)
{
  try {
    $instance = new CWLIB_IniFile($aFileName);
  } catch (Exception $e) {
    $instance = null;
  }
  return $instance;
}
