<?php
/* * *
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwide.frm.php
  Subpackage:   forms
  Description:  main form
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/** bit flags denoting items of the main menu
 */
const FORM_FILE_MENU = 1;
const FORM_BUFFER_MENU = 2;
const FORM_EDIT_MENU = 4;
const FORM_TEST_MENU = 8;
const FORM_DEBUG_MENU = 16;
const FORM_PROJECT_MENU = 32;
const FORM_SESSION_MENU = 64;
/** an associative array with the form's settings
 */
$formSettings = null;
/** Draws an item of the main menu. Param is a word with a bit flag set to
 * indicate the item.
 */
function formDrawMenu($aFlag)
{
  $menu = new CWLIB_Menu();
  // the file menu
  if ($aFlag & FORM_FILE_MENU) {
    // file-new
    $func = function () {
      return sprintf("CW_jsform.onFileNewClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Create a new file in a new buffer. ", "New...");
    $menu->addItem($item);
    // file-open
    $func = function () {
      return sprintf("CW_jsform.onFileOpenClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Open an existing file in a new buffer. ", "Open...");
    $menu->addItem($item);
    // file-save
    $func = function () {
      return sprintf("CW_jsform.onFileSaveClick('%s', true);", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Save file from the current buffer.", "Save...");
    $menu->addItem($item);
    // file-delete
    $func = function() {
      return sprintf("CW_jsform.onFileDropClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Delete a file. ", "Delete");
    $menu->addItem($item);
    // file-list
    $func = function() {
      return sprintf("CW_jsform.onFileViewdirClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Update the contents of login directory in the LoginDir tab. ", "List");
    $menu->addItem($item);
    // file-TAR
    $func = function () {
      return sprintf("CW_jsform.onFileTarClick('%s', '%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), CWLIB_settingRead($GLOBALS['formSettings'], 'general_options', 'Tar_Path'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Add your files to a TAR archive file named cwed.tar. ", "TAR...");
    $menu->addItem($item);
    // file-mail
    $func = function () {
      return sprintf("CW_jsform.onFileMailClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Send a file as an attachment to an email account. ", "Mail...");
    $menu->addItem($item);
    // file-download
    $func = function() {
      return sprintf("CW_jsform.onFileDownloadClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Download a file from login directory. ", "Download");
    $menu->addItem($item);
    // file-logout
    $func = function() {
      return sprintf("CW_jsform.onFileLogoutClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Log out. ", "Logout");
    $menu->addItem($item);
    $menu->generateHtml();
    // the buffer menu
  } else if ($aFlag & FORM_BUFFER_MENU) {
    $menu = new CWLIB_Menu();
    // buffer-switch
    $func = function() {
      return sprintf("CW_jsform.onBufferSwitchClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Switch to the buffer with specified number. ", "Switch");
    $menu->addItem($item);
    // buffer-next
    $func = function () {
      return sprintf("CW_jsform.onBufferNextClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Switch to the next buffer. ", "Next");
    $menu->addItem($item);
    $menu->generateHtml();
    // the session item
  } else if ($aFlag & FORM_SESSION_MENU) {
    $menu = new CWLIB_Menu();
    // session-set make
    $func = function () {
      return sprintf("CW_jsform.onTestSetMakefileClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Sets the default makefile to be executed on TEST->MAKE.", "Set Make");
    $menu->addItem($item);
    // session-get make
    $func = function () {
      return sprintf("CW_jsform.onTestGetMakefileClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Reads which makefile was set by TEST->SET MAKE.", "Get Make");
    $menu->addItem($item);
    // session-set exec
    $func = function () {
      return sprintf("CW_jsform.onTestSetExecutableClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Sets the executable to be tested on TEST->RUN and TEST->TERMINAL.", "Set Exec");
    $menu->addItem($item);
    // session-get exec
    $func = function () {
      return sprintf("CW_jsform.onTestGetExecutableClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Reads which executable was set by TEST->SET EXEC.", "Get Exec");
    $menu->addItem($item);
    $menu->generateHtml();
    // the edit item
  } else if ($aFlag & FORM_EDIT_MENU) {
    $menu = new CWLIB_Menu();
    // file-goto
    $item = CWLIB_menuItemFactory("#", "CW_jseditor.invokeGotoLineDlg();", "Calls the built-in GO-TO-LINE dialog.", "Goto");
    $menu->addItem($item);
    // file-search
    $item = CWLIB_menuItemFactory("#", "CW_jseditor.invokeSearchDlg();", "Calls the built-in SEARCH dialog.", "Search");
    $menu->addItem($item);
    // file-replace
    $item = CWLIB_menuItemFactory("#", "CW_jseditor.invokeReplaceDlg();", "Calls the built-in REPLACE dialog.", "Replace");
    $menu->addItem($item);
    // file-format
    $item = CWLIB_menuItemFactory("#", "CW_jseditor.formatCode();", "Autoformats editor's contents.", "Format");
    $menu->addItem($item);
    // file-functions
    $item = CWLIB_menuItemFactory("#", "CW_jsform.updateCodeNavigator();", "Updates the FUNCTIONS tab.", "Functions");
    $menu->addItem($item);
    $menu->generateHtml();
    // the test item
  } else if ($aFlag & FORM_TEST_MENU) {
    $menu = new CWLIB_Menu();
    // test-lint
    $func = function () {
      return sprintf("CW_jsform.onTestLintClick('%s','%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'GCC_Path'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Checks the syntax of the current source file.", "Lint");
    $menu->addItem($item);
    // test-compile
    $func = function () {
      return sprintf("CW_jsform.onTestCompileClick('%s','%s','%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'GCC_Path'), CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'GCC_Options'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Compiles current source file to machine code.", "Compile");
    $menu->addItem($item);
    // test-asm
    $func = function () {
      return sprintf("CW_jsform.onTestAsmClick('%s','%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'GCC_Path'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Compiles current source file to assembly.", "ASM");
    $menu->addItem($item);
    // test-make
    $func = function () {
      return sprintf("CW_jsform.onTestMakeClick('%s', '%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'Make_Path'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Executes custom makefile with .mkf extension.", "Make");
    $menu->addItem($item);
    // test-run
    $func = function () {
      return sprintf("CW_jsform.onTestRunClick('%s','%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'input_file'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Runs the executable set by TEST->SET EXEC from within the IDE using input data from the INPUT tab. ", "Run...");
    $menu->addItem($item);
    // test-terminal
    $func = function () {
      if ("1" === CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'Use_Terminal')) {
        $func_call = sprintf("CW_jsform.onTestTerminalClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
      } else {
        $func_call = sprintf("CW_jsform.showAlert('Terminal disabled by administrator.');");
      }
      return $func_call;
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Runs executable set by TEST->SET EXEC interactively in the built-in terminal emulator. ", "Terminal");
    $menu->addItem($item);
    $menu->generateHtml();
    // the Debug menu
  } else if ($aFlag & FORM_DEBUG_MENU) {
    $menu = new CWLIB_Menu();
    // debug-backtrace
    $func = function() {
      $dirName = CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir');
      $gdbPath = CWLIB_settingRead($GLOBALS['formSettings'], 'debug_options', 'GDB_Path');
      $inputName = CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'input_file');
      $batchName = CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'batch_file');
      return sprintf("CW_jsform.onTestDebugClick('%s','%s','%s', '%s');", $gdbPath, $dirName, $inputName, $batchName);
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Debugs the executable set by the TEST->SET EXEC with the BACKTRACE command. ", "Backtrace");
    $menu->addItem($item);
    $menu->generateHtml();
    // the Project menu
  } else if ($aFlag & FORM_PROJECT_MENU) {
    $menu = new CWLIB_Menu();
    // project-new
    $func = function () {
      return sprintf("CW_jsform.onProjectNewMenuItemClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Creates a new project. ", "New...");
    $menu->addItem($item);
    // project-delete
    $func = function() {
      return sprintf("CW_jsform.onProjectDropMenuItemClick('%s');", CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'));
    };
    $item = CWLIB_menuItemFactory("#", $func(), "Delete a project. ", "Delete...");
    $menu->addItem($item);
    $menu->generateHtml();
  }
  if (isset($menu)) {
    unset($menu);
  }
}
// draws the tabbed panel at the bottom of the form
function formDrawTabPanel()
{
  $pageControl = new CWLIB_PageControl();
  // The OUTPUT tab
  $tooltip = "Displays IDE messages and program output.";
  $page = CWLIB_pageFactory('divtab-1', 'tab-group-1', true, $tooltip, 'Output', $tooltip);
  $htmlObj = new CWLIB_TextArea("ideMsgElemId", "ideMsgElem", "output", "{$tooltip}.", true, CWLIB_settingRead($GLOBALS['formSettings'], 'defaults', 'output'));
  $pageControl->addPage($page, $htmlObj);
  // The INPUT tab
  $tooltip = "Input data used by programs tested on clicking the RUN menu item";
  $page = CWLIB_pageFactory('divtab-2', 'tab-group-1', false, $tooltip, 'Input', $tooltip);
  $htmlObj = new CWLIB_TextArea("inputTextAreaId", "inputTextArea", "input", "{$tooltip}.", false, CWLIB_settingRead($GLOBALS['formSettings'], 'defaults', 'input'));
  $pageControl->addPage($page, $htmlObj);
  // The ASM tab
  $tooltip = "View here the assembly output.";
  $page = CWLIB_pageFactory('divtab-3', 'tab-group-1', false, $tooltip, 'Asm', $tooltip);
  $htmlObj = new CWLIB_TextArea("asmElemId", "asmElem", "output", "{$tooltip}.", false, $tooltip);
  $pageControl->addPage($page, $htmlObj);
  // The FUNCTIONS  tab
  $tooltip = "the list of all function declarations and calls from the current buffer. ";
  $page = CWLIB_pageFactory('divtab-4', 'tab-group-1', false, $tooltip, 'Functions', $tooltip);
  $htmlObj = new CWLIB_TextArea("navigatorElemId", "navigatorElem", "functionstab", "{$tooltip}.", false, $tooltip);
  $pageControl->addPage($page, $htmlObj);
  // The LOGIN DIR tab
  $tooltip = "Displays contents of user personal directory.";
  $page = CWLIB_pageFactory('divtab-5', 'tab-group-1', false, $tooltip, 'LoginDir', $tooltip);
  $htmlObj = new CWLIB_TextArea("viewdirElemId", "viewdirElem", "output", "{$tooltip}.", true, CWLIB_settingRead($GLOBALS['formSettings'], 'defaults', 'output'));
  $pageControl->addPage($page, $htmlObj);
  // The BUFFERS tab
  $tooltip = "Displays the list of currently opened buffers.";
  $page = CWLIB_pageFactory('divtab-6', 'tab-group-1', false, $tooltip, 'Buffers', $tooltip);
  $htmlObj = new CWLIB_TextArea("buffersElemID", "buffersElem", "output", "{$tooltip}.", true, CWLIB_settingRead($GLOBALS['formSettings'], 'defaults', 'output'));
  $pageControl->addPage($page, $htmlObj);
  // The SCRIBBLE tab
  $tooltip = "Scratch board for any notes you want.";
  $page = CWLIB_pageFactory('divtab-7', 'tab-group-1', false, $tooltip, 'Scribble', $tooltip);
  $htmlObj = new CWLIB_TextArea("notesElemId", "notesElem", "scribble", "{$tooltip}.", false, $tooltip);
  $pageControl->addPage($page, $htmlObj);
  // The SNIPPETS tab
  $tooltip = "Insert predefined code snippets.";
  $page = CWLIB_pageFactory('divtab-8', 'tab-group-1', false, $tooltip, 'Snippets', $tooltip);
  $htmlObj = new CWLIB_Select("snippetboxId", "snippetbox", "snippetbox", "select a snippet", "snippet", 
          "if (this.selectedIndex) CW_jseditor.insertText(this.options[this.selectedIndex].text);");
  $pageControl->addPage($page, $htmlObj);  
  // The ABOUT tab
  $tooltip = "Basic information about the application.";
  $page = CWLIB_pageFactory('divtab-9', 'tab-group-1', false, $tooltip, 'About', $tooltip);
  $htmlObj = new CWLIB_TextArea("aboutElemId", "aboutElem", "output", "{$tooltip}.", true, CWLIB_APP_VERSION . (defined('CWLIB_DEBUG') ? " \n\n(debug mode)" : ""));
  $pageControl->addPage($page, $htmlObj);
  // The HELP tab
  $tooltip = "Help.";
  $page = CWLIB_pageFactory('divtab-10', 'tab-group-1', false, $tooltip, 'Help', $tooltip);
  $htmlObj = new CWLIB_TextArea("helpElemId", "helpElem", "output", "{$tooltip}.", true, $GLOBALS['CW_helpStr']);
  $pageControl->addPage($page, $htmlObj);
  $pageControl->generateHtml();
}
/** outputs the form's HTML
 */
function formDrawPage()
{
  echo "<!DOCTYPE html>";
  echo "<html>";
  echo "<head>";
  echo "<meta charset='utf-8'/>";
  echo "<meta name='description' content='cwed: write and test your C++ code snippets over the Web'/>";
  echo "<meta name='author' content='The CWED team'/>";
  echo "<title>CWED</title>";
  $elem = new CWLIB_LinkRel('cwedicon', 'cwedicon', 'icon', '../../../res/cwed.ico', 'image/x-icon');
  echo $elem->generateHtml();
  $elem = new CWLIB_LinkRel('cwedicon', 'cwedicon', 'shortcut icon', '../../../res/cwed.ico', 'image/x-icon');
  echo $elem->generateHtml();
  $hrefs = array(
      '../../../js/vendor/cmirror/docs.css',
      '../../../js/vendor/cmirror/codemirror.css',
      '../../../js/vendor/cmirror/show-hint.css',
      '../../../js/vendor/cmirror/dialog.css',
      '../../../js/vendor/cmirror/neat.css',
      '../../../js/vendor/blurt/blurt.min.css',
      '../../../css/cwmain.css'
  );
  $arrcount = count($hrefs);
  for ($i = 0; $i < $arrcount; $i++) {
    $name = "cssref_{$i}";
    $elem = new CWLIB_LinkRel($name, $name, 'stylesheet', $hrefs[$i], null);
    echo $elem->generateHtml();
  }
  $hrefs = array(
      '../../../js/vendor/cmirror/codemirror.js',
      '../../../js/vendor/cmirror/show-hint.js',
      '../../../js/vendor/cmirror/anyword-hint.js',
      '../../../js/vendor/cmirror/closebrackets.js',
      '../../../js/vendor/cmirror/matchbrackets.js',
      '../../../js/vendor/cmirror/clike.js',
      '../../../js/vendor/cmirror/dialog.js',
      '../../../js/vendor/cmirror/searchcursor.js',
      '../../../js/vendor/cmirror/search.js',
      '../../../js/vendor/cmirror/active-line.js',
      '../../../js/vendor/cmirror/jump-to-line.js',
      '../../../js/vendor/cmirror/formatting.js',
      '../../../js/vendor/blurt/blurt.min.js',
      '../../../js/app/cwutils.js',
      '../../../js/app/cweditor.js',
      '../../../js/app/cwbuffer.js',
      '../../../js/app/cwform.js',
      '../../../js/app/cwwindow.js'
  );
  foreach ($hrefs as &$href) {
    CWLIB_logPrintf("<script src='%s'></script>", $href);
  }
  echo "</head>";
  echo "<body>";
  echo "<form name='mainForm' method='POST'>";
  echo "<div class='divtop' align='left'>";
  echo "<div class='dropdown'>";
  $elem = new CWLIB_Button('fileMenuID', 'fileMenu', 'dropbtn', 'File Manipulation', '&Xi; File', 'onFileDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='fileDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_FILE_MENU);
  echo "</div>\n";
  $elem = new CWLIB_Button('bufferMenuID', 'bufferMenu', 'dropbtn', 'Buffer Manipulation', '&Xi; Buffer', 'onBufferDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='bufferDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_BUFFER_MENU);
  echo "</div>\n";
  $elem = new CWLIB_Button('editMenuID', 'editMenu', 'dropbtn', 'Basic Edit Operations', '&Xi; Edit', 'onEditDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='editDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_EDIT_MENU);
  echo "</div>\n";
  // session drop-down
  $elem = new CWLIB_Button('sessionMenuID', 'sessionMenu', 'dropbtn', 'Session Management', '&Xi; Session', 'onSessionDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='sessionDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_SESSION_MENU);
  echo "</div>\n";
  // test drop-down
  $elem = new CWLIB_Button('testMenuID', 'testMenu', 'dropbtn', 'Testing Functions', '&Xi; Test', 'onTestDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='testDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_TEST_MENU);
  echo "</div>\n";
  // debug drop-down
  $elem = new CWLIB_Button('debugMenuID', 'debugMenu', 'dropbtn', 'Debugging Functions', '&Xi; Debug', 'onDebugDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='debugDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_DEBUG_MENU);
  echo "</div>\n";
  // project drop-down
  $elem = new CWLIB_Button('projectMenuID', 'projectMenu', 'dropbtn', 'Project Manipulation', '&Xi; Project', 'onProjectDropDownClick();');
  echo $elem->generateHtml();
  echo "<div id='projectDropdown' class='dropdown-content'>";
  formDrawMenu(FORM_PROJECT_MENU);
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "<table border=1 bordercolor=yellow>";
  echo "<tr>";
  echo "<td width='15%' height='100%'>";
  echo "<div class='divfile' align='center'>";
  //
  echo "<p>";
  echo "<label class='logo'>";
  echo "CWED 0.8";
  echo "</label>";
  echo "<br>";
  echo "</p>";
  //
  echo "<p>";
  echo "<label class='copyright'>";
  echo CW_BRIEF_COPYRIGHT;
  echo "</label>";
  echo "<br>";
  echo "</p>";  
  //
  echo "<p>";
  echo "Current Login";
  echo "<br>";
  $elem = new CWLIB_Input('text', 'loginTagID', 'loginTag', 'filename', 'Current Login', htmlspecialchars(CWLIB_sessionGetCurrentLogin()), '');
  echo $elem->generateHtml();
  echo "</p>";
  //
  echo "<p>";
  echo "Login Directory";
  echo "<br>";
  $logindir = substr(CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir'), strlen(CWLIB_APP_DATA_DIR_PATH) + 1);
  $elem = new CWLIB_Input('text', 'loginDirID', 'loginDir', 'filename', 'Login Directory', htmlspecialchars($logindir), '');
  echo $elem->generateHtml();
  echo "</p>";
  //
  echo "<p>";
  echo "Current Buffer";
  echo "<br>";
  $elem = new CWLIB_Input('text', 'editorlabelID', 'editorlabel', 'filename', 'Current source file', '', '');
  echo $elem->generateHtml();
  echo "</p>";
  //
  echo "<p>";
  echo "Buffer Status";
  echo "<br>";
  $elem = new CWLIB_Input('text', 'bufferStatusID', 'bufferStatus', 'filename', 'Shows if the current buffer modified', '', '');
  echo $elem->generateHtml();
  echo "</p>";
  //
  echo "</div>";
  echo "</td>";
  echo "<td width='85%'>";
  echo "<div class='diveditor'>";
  CWLIB_logPrintf("<textarea name='editor' id='editorId' style='visibility:hidden;'>%s</textarea>", CWLIB_settingRead($GLOBALS['formSettings'], 'defaults', 'editor_contens'));
  echo "</div>";
  echo "</td>";
  echo "</tr>";
  echo "</table>";
  echo "<div class='divtabpanel'>";
  formDrawTabPanel();
  echo "</div>";
  $elem = new CWLIB_Input('hidden', 'fileNameInputId', 'fileNameInput', 'filename', '', '', '');
  echo $elem->generateHtml();
  $elem = new CWLIB_Input('hidden', 'makefileNameInput', 'makefileNameInputId', 'filename', '', 'test.mkf', '');
  echo $elem->generateHtml();
  $elem = new CWLIB_Input('hidden', 'execfileNameInput', 'execfileNameInputId', 'filename', '', 'test.out', '');
  echo $elem->generateHtml();
  echo "<script>CW_jseditor.init();CW_jseditor.onModifyCallback=CW_jsform.handleModified;fillSnippetBox();</script>";
  echo "</form>";
  echo "</body>";
  echo "</html>";
}
/** initializes the form */
function formInit()
{
  if (!defined('AUTHENTICATED')) {
    die('Non-authenticated form');
  }
  set_error_handler(function_exists('CW_errorHandler') ? 'CW_errorHandler' : NULL);
  set_exception_handler(function_exists('CW_exceptionHandler') ? 'CW_exceptionHandler' : NULL);
  if (!CWLIB_sessionVarIsset('cwlogin')) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: formInit(): " . $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_LOGIN]);
    }
    CWLIB_errorThrowFatal($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_LOGIN]);
  }
  $iniFile = CWLIB_iniFileFactory(CWLIB_CONFIG_FILE_PATH);
  if (is_null($iniFile)) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: formInit(): " . $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CONFIG_FILE]);
    }
    die($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CONFIG_FILE]);
  }
  $login = CWLIB_sessionGetCurrentLogin();
  $loginDir = CWLIB_USER_DIR_PATH . DIRECTORY_SEPARATOR . $login;
  $GLOBALS['formSettings'] = array();
  CWLIB_settingWrite($GLOBALS['formSettings'], 'debug_options', 'GCC_Path', $iniFile->readParameter('gcc_path', CWLIB_DEFAULT_GCC_PATH));
  CWLIB_settingWrite($GLOBALS['formSettings'], 'debug_options', 'GDB_Path', $iniFile->readParameter('gdb_path', CWLIB_DEFAULT_GDB_PATH));
  CWLIB_settingWrite($GLOBALS['formSettings'], 'debug_options', 'Make_Path', $iniFile->readParameter('make_path', CWLIB_DEFAULT_MAKE_PATH));
  CWLIB_settingWrite($GLOBALS['formSettings'], 'debug_options', 'GCC_Options', CWLIB_DEFAULT_GCC_OPTIONS);
  CWLIB_settingWrite($GLOBALS['formSettings'], 'debug_options', 'Use_Terminal', $iniFile->readParameter('use_terminal', ""));
  CWLIB_settingWrite($GLOBALS['formSettings'], 'general_options', 'Tar_Path', $iniFile->readParameter('tar_path', CWLIB_DEFAULT_TAR_PATH));
  CWLIB_settingWrite($GLOBALS['formSettings'], 'defaults', 'editor_contens', CWLIB_DEFAULT_EDITOR_CONTENTS);
  CWLIB_settingWrite($GLOBALS['formSettings'], 'defaults', 'input', CWLIB_DEFAULT_INPUT_DATA);
  CWLIB_settingWrite($GLOBALS['formSettings'], 'defaults', 'output', CWLIB_DEFAULT_IDE_MSG);
  CWLIB_settingWrite($GLOBALS['formSettings'], 'paths', 'login_dir', $loginDir);
  CWLIB_settingWrite($GLOBALS['formSettings'], 'paths', 'input_file', $loginDir . DIRECTORY_SEPARATOR . "{$login}.data");
  CWLIB_settingWrite($GLOBALS['formSettings'], 'paths', 'batch_file', $loginDir . DIRECTORY_SEPARATOR . "{$login}.batch");
  if (!CWLIB_dirExists(CWLIB_USER_DIR_PATH)) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: formInit(): " . $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_USERDIR]);
    }
    CWLIB_errorThrowFatal($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_USERDIR]);
  }
  $dirName = CWLIB_settingRead($GLOBALS['formSettings'], 'paths', 'login_dir');
  if (!CWLIB_dirExists($dirName) && (!CWLIB_dirMake($dirName))) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: formInit(): " . $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_USERDIR]);
    }
    CWLIB_errorThrowFatal($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_USERDIR]);
  }
  if (!CWLIB_fileExists(CWLIB_CONFIG_FILE_PATH)) {
    if (true === DEBUG_PAGE) {
      CWLIB_logError("CWED ERROR **: formInit(): " . $GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CONFIG_FILE]);
    }
    CWLIB_errorThrowFatal($GLOBALS['_CWLIB_errors'][CWLIB_ERROR_CONFIG_FILE]);
  }
  return true;
}
/** the script's entry-point
 */
function formMain()
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  formInit() or die("Failed to initialize the script");
  formDrawPage();
}
formMain();
?>
