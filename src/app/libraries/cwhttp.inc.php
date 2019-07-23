<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwhttp.inc.php
  Subpackage:   library
  Summary:      routines for working with HTTP headers
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Redirects to given URL.
 */
function CWLIB_headerRedirectTo($url)
{
  header("Location: " . $url);
}
?>
