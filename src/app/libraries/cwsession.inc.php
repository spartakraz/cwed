<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwsession.inc.php
  Subpackage:   library
  Summary:      session management routines
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* returns current login
 */
function CWLIB_sessionGetCurrentLogin()
{
  return CWLIB_sessionVarRead('cwlogin');
}
