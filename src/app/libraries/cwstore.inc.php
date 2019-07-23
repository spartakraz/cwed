<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwstore.inc.php
  Subpackage:   library
  Summary:      interface to file storing logins with their passwords (login storage)
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Provides interface to the login storage. The storage
  stores data in the form of "key=value" items where
  key is login and value is password.
 */
class CWLIB_LoginStorage
{
  /* a symbol used to separate keys from values
   */
  const KEY_VALUE_SEPARATOR = '=';
  /* numerical code of the error indicating empty login
   */
  const ERR_EMPTY_LOGIN = 1;
  /* numerical code of the error indicating empty password
   */
  const ERR_EMPTY_PASSWORD = 2;
  /* numerical code of the error indicating failed access to the storage
   */
  const ERR_LOGIN_STORAGE = 4;
  /* numerical code of the error indicating invalid login
   */
  const ERR_LOGIN_NOT_FOUND = 8;
  /* numerical code of the error indicating wrong password
   */
  const ERR_WRONG_PASSWORD = 16;
  /*  numerical code of the error indicating user's attempts to register
    already existing login
   */
  const ERR_LOGIN_EXISTS = 32;
  /* Path to the storage's file.
   */
  private $mFileName = null;

  /* Numerical code of the last error occured within the class.
   */
  private $mErrorCode = null;
  /* Default constructor. Parameter is the path to the storage's file.
   */
  function __construct($aFileName)
  {
    $this->setFileName($aFileName);
  }
  /* returns numerical code of the last error occured within the class
   */
  public function errorCode()
  {
    return $this->mErrorCode;
  }
  /* sets the path to the storage
   */
  public function setFileName($aFileName)
  {
    $this->mFileName = $aFileName;
  }
  /* returns the path to the storage
   */
  public function getFileName()
  {
    return $this->mFileName;
  }
  /*  Checks if given login is already registered in the storage.
    Returns boolean showing the results of checking.
   */
  public function checkLogin($aLogin)
  {
    if (!CWLIB_stringIsOk($aLogin)) {
      $this->mErrorCode = self::ERR_EMPTY_LOGIN;
      return false;
    }
    if (!($handle = fopen($this->mFileName, "r"))) {
      $this->mErrorCode = self::ERR_LOGIN_STORAGE;
      return false;
    }
    while (($line = fgets($handle)) !== false) {
      $tokens = explode(self::KEY_VALUE_SEPARATOR, $line);
      if (strcmp($aLogin, $tokens[0]) === 0) {
        fclose($handle);
        $this->mErrorCode = self::ERR_LOGIN_EXISTS;
        return true;
      }
    }
    fclose($handle);
    $this->mErrorCode = self::ERR_LOGIN_NOT_FOUND;
    return false;
  }
  /* Checks whether login's password is correct. Returns boolean.
   */
  function checkPassword($aLogin, $aPassword)
  {
    if (!CWLIB_stringIsOk($aPassword)) {
      $this->mErrorCode = self::ERR_EMPTY_PASSWORD;
      return false;
    }
    if (!($handle = fopen($this->mFileName, 'r'))) {
      $this->mErrorCode = self::ERR_LOGIN_STORAGE;
      return false;
    }
    $crypted = CWLIB_stringCrypt($aPassword, 'e');
    while (($line = fgets($handle)) !== false) {
      $tokens = explode(self::KEY_VALUE_SEPARATOR, $line);
      if (($aLogin === trim($tokens[0])) && ($crypted === trim($tokens[1]))) {
        fclose($handle);
        return true;
      }
    }
    fclose($handle);
    $this->mErrorCode = self::ERR_WRONG_PASSWORD;
    return false;
  }
  /* Registers given login and password in the login storage.
   * Returns boolean.
   */
  function registerLogin($aLogin, $aPassword)
  {
    if ($this->checkLogin($aLogin)) {
      $this->mErrorCode = self::ERR_LOGIN_EXISTS;
      return false;
    }
    if (!CWLIB_stringIsOk($aLogin) || !CWLIB_stringIsOk($aPassword)) {
      return false;
    }
    return (FALSE === CWLIB_fileWrite($this->mFileName, sprintf("%s%s%s\n", $aLogin, self::KEY_VALUE_SEPARATOR, $aPassword), TRUE)) ? false : true;
  }
}
/*  an instance of CWLIB_LoginStorage thru which other scripts
  are to access the class's functionality
 */
$_CWLIB_loginStorage = NULL;

/* PROCEDURAL HELPER API FOR WRAPPING THE FUNCTIONALITY OF THE CWLIB_LOGINSTORAGE CLASS */

/* procedural wrapper around the constructor
 */
function CWLIB_loginStorageInit()
{
  global $_CWLIB_loginStorage;
  $_CWLIB_loginStorage = new CWLIB_LoginStorage(CWLIB_LOGIN_STORAGE_PATH);
}
/*  Returns string representation of the given numerical code
  of an error occured within the class.
 */
function CWLIB_loginStorageGetErrorMessage($aErrCode)
{
  $msg = "Unknown error.";
  switch ($aErrCode) {
    case CWLIB_LoginStorage::ERR_EMPTY_LOGIN:
      $msg = "ERROR: empty login";
      break;
    case CWLIB_LoginStorage::ERR_EMPTY_PASSWORD:
      $msg = "ERROR: empty password";
      break;
    case CWLIB_LoginStorage::ERR_LOGIN_STORAGE:
      $msg = "ERROR: database error";
      break;
    case CWLIB_LoginStorage::ERR_LOGIN_NOT_FOUND:
      $msg = "ERROR: login not found";
      break;
    case CWLIB_LoginStorage::ERR_WRONG_PASSWORD:
      $msg = "ERROR: wrong password";
      break;
    case CWLIB_LoginStorage::ERR_LOGIN_EXISTS:
      $msg = "ERROR: login exists";
      break;
    default:
      $msg = "ERROR: database access failed";
      break;
  }
  return $msg;
}
/* returns message of the last error occured within the class
 */
function CWLIB_loginStorageGetLastErrorMessage()
{
  global $_CWLIB_loginStorage;

  return CWLIB_loginStorageGetErrorMessage($_CWLIB_loginStorage->errorCode());
}
/* procedural wrapper around the checkLogin() method
 */
function CWLIB_loginStorageCheckLogin($aLogin)
{
  global $_CWLIB_loginStorage;

  $res = $_CWLIB_loginStorage->checkLogin($aLogin);
  return $res;
}
/* procedural wrapper around the checkPassword() method
 */
function CWLIB_loginStorageCheckPassword($aLogin, $aPassword)
{
  global $_CWLIB_loginStorage;

  $res = $_CWLIB_loginStorage->checkPassword($aLogin, $aPassword);
  return $res;
}
/* procedural wrapper around the registerLogin() method
 */
function CWLIB_loginStorageRegisterLogin($aLogin, $aPassword)
{
  global $_CWLIB_loginStorage;

  return $_CWLIB_loginStorage->registerLogin($aLogin, $aPassword);
}
