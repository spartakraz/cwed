<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwsys.inc.php
  Subpackage:   library
  Summary:      wrappers around POSIX system functions
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Returns name of the user under which the application's script is running.
 */
function CWLIB_sysGetUserName()
{
  $userInfo = posix_getpwuid(posix_getuid());
  return $userInfo['name'];
}
/* Returns name of the group under which the application's script is running.
 */
function CWLIB_sysGetGroupName()
{
  $groupInfo = posix_getgrgid(posix_getgid());
  return $groupInfo['name'];
}
?>
