<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwlogout.srv.php
  Subpackage:   service
  Summary:      logs out from current session and goes back to the login form
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (session_status() === PHP_SESSION_ACTIVE) {
  if (isset($_SESSION['cwlogin'])) {
    unset($_SESSION['cwlogin']);
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 86400, '/');
    }
    session_destroy();
  } else {
    die("Login error!!!");
  }
}
if (isset($_GET['toLogin'])) {
  header('Location: ../forms/cwlogin.frm.php');
}
?>

