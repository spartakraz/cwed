<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwdownload.srv.php
  Subpackage:   service
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
/* downloads a file whose path is passed thru $_GET['filepath']
 */
function CWLIB_serviceDownload()
{
  $path = trim(CWLIB_getVarRead('filepath'));
  $showName = basename($path);
  CWLIB_fileExists($path) or die("Download error");
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header('Expires: 0');
  header("Content-Disposition: attachment; filename=$showName");
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header("Content-Type: application/force-download");
  header("Content-Transfer-Encoding: binary");
  header('Content-Length: ' . filesize($path));
  ob_clean();
  flush();
  readfile($path);
}
CWLIB_serviceDownload();
?>
