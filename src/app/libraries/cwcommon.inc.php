<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwcommon.inc.php
  Subpackage:   library
  Summary:      common defintions used all over the application's scripts
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
if (getcwd() == dirname(__FILE__)) {
  die('Attack stopped');
}
/* the application's version in a string form */
const CWLIB_APP_VERSION = "CWED (C++ IDE on the Web)\nversion 0.8.5\n\nCopyright(C) The CWED team";
/* copyright info */
const CW_BRIEF_COPYRIGHT = "&copy; the CWED team";
/* path to the application's data dir */
const CWLIB_APP_DATA_DIR_PATH = DIRECTORY_SEPARATOR . 'srv' . DIRECTORY_SEPARATOR . 'cwed.d';
/* shows where inside the data dir users' personal dirs are located */
const CWLIB_USER_DIR_PATH = CWLIB_APP_DATA_DIR_PATH . DIRECTORY_SEPARATOR . 'users';
/* shows where inside the data dir the application's config file is located */
const CWLIB_CONFIG_FILE_PATH = CWLIB_APP_DATA_DIR_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'cwed.conf';
/* shows where inside the data dir temp file is located */
const CWLIB_TEMP_FILE_PATH = CWLIB_APP_DATA_DIR_PATH . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'cwed.temp';
/* shows where inside the data dir the application's log file is located */
const CWLIB_LOG_FILE_PATH = CWLIB_APP_DATA_DIR_PATH . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . 'cwed.log';
/* maximum size (in bytes) of the log file */
const CWLIB_LOG_FILE_MAX_SIZE = 5000000;
/* path to the file where logins (with their passwords) are stored */
const CWLIB_LOGIN_STORAGE_PATH = CWLIB_USER_DIR_PATH . DIRECTORY_SEPARATOR . 'logindb.dat';
/* path to the gcc compiler accepted by default if it hasn't been specifiied in the config file */
const CWLIB_DEFAULT_GCC_PATH = 'g++';
/* path to the gdb debugger accepted by default if it hasn't been specifiied in the config file */
const CWLIB_DEFAULT_GDB_PATH = 'gdb';
/* path to the Make utility accepted by default if it hasn't been specifiied in the config file */
const CWLIB_DEFAULT_MAKE_PATH = 'make';
/* path to the TAR utility accepted by default if it hasn't been specifiied in the config file */
const CWLIB_DEFAULT_TAR_PATH = 'tar';
/* default compiler options */
const CWLIB_DEFAULT_GCC_OPTIONS = '-g -Wall -Wextra -Wpedantic -Werror -Wfatal-errors';
/* message shown by default in the OUTPUT tab of the application's main form */
const CWLIB_DEFAULT_IDE_MSG = 'Done';
/* default contents of the main form's text editor */
const CWLIB_DEFAULT_EDITOR_CONTENTS = "#include <iostream>\n\nint main() \n{\n\treturn 0;\n}";
/* default contents of the main form's INPUT tab */
const CWLIB_DEFAULT_INPUT_DATA = "10\n20";
/* numerical codes of the application's built-in errors */
const CWLIB_ERROR_CONFIG_FILE = 2;
const CWLIB_ERROR_LOGIN = 3;
const CWLIB_ERROR_USERDIR = 4;
const CWLIB_ERROR_MAIL = 5;
const CWLIB_ERROR_CREATE_FILE = 6;
const CWLIB_ERROR_OPEN_FILE = 7;
const CWLIB_ERROR_SAVE_FILE = 8;
const CWLIB_ERROR_DROP_FILE = 9;
const CWLIB_ERROR_FILE_EXT = 11;
const CWLIB_ERROR_IO = 12;
const CWLIB_ERROR_MAKE = 13;
const CWLIB_ERROR_TAR = 14;
const CWLIB_ERROR_EXEC = 15;
const CWLIB_ERROR_SHELLCMD = 16;
/* defines mappings from errors' numerical codes to their respective string representations */
$_CWLIB_errors = array(
    CWLIB_ERROR_CONFIG_FILE => "CWLIB_ERROR **: failed to read from configuration file",
    CWLIB_ERROR_LOGIN => "CWLIB_ERROR **: failed to identify current login",
    CWLIB_ERROR_USERDIR => "CWLIB_ERROR **: failed to locate userdir",
    CWLIB_ERROR_MAIL => "CWLIB_ERROR **: failed to deliver email",
    CWLIB_ERROR_CREATE_FILE => "CWLIB_ERROR **: failed to create a file",
    CWLIB_ERROR_OPEN_FILE => "CWLIB_ERROR **: failed to open a file",
    CWLIB_ERROR_SAVE_FILE => "CWLIB_ERROR **: failed to save a file",
    CWLIB_ERROR_DROP_FILE => "CWLIB_ERROR **: failed to drop a file",
    CWLIB_ERROR_FILE_EXT => "CWLIB_ERROR **: unsupported file extension",
    CWLIB_ERROR_IO => "CWLIB_ERROR **: failed I/O operation",
    CWLIB_ERROR_MAKE => "CWLIB_ERROR **: failed to execute a makefile",
    CWLIB_ERROR_TAR => "CWLIB_ERROR **: failed to execute TAR",
    CWLIB_ERROR_EXEC => "CWLIB_ERROR **: failed to run an executable file",
    CWLIB_ERROR_SHELLCMD => "CWLIB_ERROR **: failed to run a shell command"
);
/* an enum whose members are bit flags denoting a specific superglobal array */
abstract class CWLIB_HTTP_Vars_Enum
{
  /* when this bit flag is on, it denotes the $_POST superglobal */
  const CWLIB_POST_VARS = 1 << 1;
  /* when this bit flag is on, it denotes the $_GET superglobal */
  const CWLIB_GET_VARS = 1 << 2;
  /* when this bit flag is on, it denotes the $_SERVER superglobal */
  const CWLIB_SERVER_VARS = 1 << 3;
  /* when this bit flag is on, it denotes the $_SESSION superglobal */
  const CWLIB_SESSION_VARS = 1 << 4;
  /* when this bit flag is on, it denotes the $_COOKIE superglobal */
  const CWLIB_COOKIE_VARS = 1 << 5;
}
?>
