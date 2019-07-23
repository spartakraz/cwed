<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwfile.inc.php
  Subpackage:   library
  Summary:      file routines
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* checks if given file is a regular file and returns boolean
 */
function CWLIB_fileIsRegular($aFileName)
{
  return is_file($aFileName);
}
/* Checks if a file exists and returns boolean.
 */
function CWLIB_fileExists($aFileName)
{
  return file_exists(realpath($aFileName));
}
/* Checks if a file is readable and returns boolean.
 */
function CWLIB_fileIsReadable($aFileName)
{
  return is_readable($aFileName);
}
/* Checks if a file is writable and returns boolean.
 */
function CWLIB_fileIsWritable($aFileName)
{
  return is_writable($aFileName);
}
/* Attempts to drop a file and returns boolean indicating whether or not
  the operation was successful.
 */
function CWLIB_fileDrop($aFileName)
{
  return CWLIB_fileExists($aFileName) && unlink($aFileName);
}
/* Returns contents of a file as a string.
 */
function CWLIB_fileRead($aFileName)
{
  return !CWLIB_fileIsReadable($aFileName) ? NULL : file_get_contents($aFileName);
}
/*  Writes data to a file in a binary-safe way. Params include path to the file,
  data itself and flag indicating whether or not the operation must be done in
  the append mode. Returns boolean indicating whether or not the operation was successful.
 */
function CWLIB_fileWrite($aFileName, $aData, $aAppendMode = false)
{
  if (is_null($aFileName) || empty(trim($aFileName)) || is_null($aData) || !is_string($aData)) {
    return FALSE;
  }
  if (FALSE === ($fp = fopen($aFileName, $aAppendMode === true ? 'a' : 'w+'))) {
    return FALSE;
  }
  if (FALSE === flock($fp, LOCK_EX)) {
    fclose($fp);
    return FALSE;
  }
  $rc = fwrite($fp, preg_replace('/\r\n?/', "\n", $aData));
  fclose($fp);
  return $rc;
}
/* Writes text contents to a file in the overwrite mode. Returns number of bytes written.
 */
function CWLIB_filePutContents($aFileName, $aContents)
{
  return file_put_contents($aFileName, $aContents);
}
/* Writes text contents to a file in the appending mode. Returns number of bytes written.
 */
function CWLIB_filePutContentsAppend($aFileName, $aContents)
{
  return file_put_contents($aFileName, $aContents, FILE_APPEND);
}
function CWLIB_filePutContentsAppendArray($aFileName, array &$aArray)
{
  foreach ($aArray as &$item) {
    CWLIB_filePutContentsAppend($aFileName, $item);
  }
}
/* Extracts extension from given path.
 */
function CWLIB_fileGetExtension($aPath)
{
  return pathinfo($aPath, PATHINFO_EXTENSION);
}
/* Returns extenstion assigned to executable files under current OS.
 */
function CWLIB_fileGetExecutableExt()
{
  if (defined('CW_IS_WINDOWS')) {
    return '.exe';
  } else if (defined('CW_IS_UNIX')) {
    return '.out';
  } else {
    return '.out';
  }
}
/* Checks if a directory exists and returns boolean.
 */
function CWLIB_dirExists($aDirName)
{
  $path = realpath($aDirName);
  return file_exists($path) && is_dir($path);
}
/* Attempts to create specified directory and returns boolean.
 */
function CWLIB_dirMake($aDirName)
{
  return CWLIB_dirExists($aDirName) ? FALSE : mkdir($aDirName);
}
/* Attempts to drop given directory and returns boolean.
 */
function CWLIB_dirDrop($aDirName)
{
  $it = new RecursiveDirectoryIterator($aDirName, RecursiveDirectoryIterator::SKIP_DOTS);
  $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
  foreach ($files as $file) {
    if ($file->isDir()) {
      if (!rmdir($file->getRealPath()))
        return FALSE;
    } else {
      if (!unlink($file->getRealPath()))
        return FALSE;
    }
  }
  return rmdir($aDirName);
}
/* Returns a string array with file names from given directory.
 */
function CWLIB_dirGetList($aDirName)
{
  if (!CWLIB_dirExists($aDirName)) {
    return NULL;
  }
  $list = array();
  $dirIter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($aDirName));
  foreach ($dirIter as $item) {
    $stats = stat($item->getPathname());
    if ($item->isFile()) {
      $list[] = "[" . date("m-d-Y", $stats['mtime']) . "] " . "[f] " . substr($item->getPathname(), strlen(CWLIB_USER_DIR_PATH));
    } else if ($item->isDir()) {
      $list[] = "[" . date("m-d-Y", $stats['mtime']) . "] " . "[d] " . substr($item->getPathname(), strlen(CWLIB_USER_DIR_PATH));
    } else {
      $list[] = "[" . date("m-d-Y", $stats['mtime']) . "] " . "[u] " . substr($item->getPathname(), strlen(CWLIB_USER_DIR_PATH));
    }
  }
  ksort($list);
  return $list;
}
?>
