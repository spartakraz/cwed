<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwmail.ajx.php
  Subpackage:   ajax
  Summary:      invoked by Ajax requests to email a file from user's home dir
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (!defined('CWAJAX_REQUEST')) {
  define('CWAJAX_REQUEST', true);
}
define('DEBUG_MAIL', false);
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwcommon.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "cwlib.inc.php";
require_once ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "PHPMailer" . DIRECTORY_SEPARATOR . "PHPMailerAutoload.php";
/*  Emails a file from user's home dir. Params are passed thru $_GET and are as follows:
  address: email address of the recipent
  attachment: path to the file
  Returns status of the operation in a string form.
 */
function CWAJAX_mailSend()
{
  ob_clean();
  $addr = CWLIB_getVarRead('address');
  $attachment = CWLIB_getVarRead('attachment');
  $iniFile = parse_ini_file(CWLIB_CONFIG_FILE_PATH);
  $mailOptions = array();
  $mailOptions['host'] = $iniFile['host'];
  $mailOptions['username'] = $iniFile['username'];
  $mailOptions['password'] = $iniFile['password'];
  $mailOptions['smtp_secure'] = $iniFile['smtp_secure'];
  $mailOptions['port'] = $iniFile['port'];
  $mailOptions['mailer'] = $iniFile['mailer'];
  $mailOptions['recipient'] = $addr;
  $mailOptions['attachment'] = $attachment;
  $mail = new PHPMailer(true);
  try {
    if (true === DEBUG_MAIL) {
      $mail->SMTPDebug = 3;
    }
    $mail->isSMTP();
    $mail->Host = !is_null($mailOptions['host']) ? $mailOptions['host'] : 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = !is_null($mailOptions['username']) ? $mailOptions['username'] : 'user@example.com';
    $mail->Password = !is_null($mailOptions['password']) ? $mailOptions['password'] : 'secretkey';
    $mail->SMTPSecure = !is_null($mailOptions['smtp_secure']) ? $mailOptions['smtp_secure'] : 'tlp';
    $mail->Port = !is_null($mailOptions['port']) ? $mailOptions['port'] : 587;
    $mail->setFrom((!is_null($mailOptions['username']) ? $mailOptions['username'] : 'user@example.com'), (!is_null($mailOptions['mailer']) ? $mailOptions['mailer'] : 'Mailer'));
    $mail->addAddress((!is_null($mailOptions['recipient']) ? $mailOptions['recipient'] : 'joe@example.net'));
    $mail->addAttachment((!is_null($mailOptions['attachment']) ? $mailOptions['attachment'] : '/tmp/example.txt'));
    $mail->isHTML(true);
    $mail->Subject = 'Files from CWED';
    $mail->Body = 'Hello!<br>Get files from CWED!';
    $mail->AltBody = 'Hello, get files from CWED!';
    $rc = $mail->send();
    return (false === $rc) ? $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_MAIL] . "\n" . $mail->ErrorInfo : CWLIB_DEFAULT_IDE_MSG;
  } catch (Exception $e) {
    return $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_MAIL] . "\n" . $mail->ErrorInfo . '\n' . $e;
  }
}
$res = CWAJAX_mailSend();
echo $res;
?>
