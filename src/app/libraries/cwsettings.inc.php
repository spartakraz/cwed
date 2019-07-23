<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwsettings.inc.php
  Subpackage:   library
  Summary:      routines for accessing "key->value" associative arrays
  storing script settings
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
function CWLIB_settingWrite(&$keyValArray, $aSection, $aKey, $aValue)
{
  $keyValArray[$aSection][$aKey] = $aValue;
}
function CWLIB_settingRead(&$keyValArray, $aSection, $aKey)
{
  return $keyValArray[$aSection][$aKey];
}
?>

