/// Stuff used by the main form
var CW_jsform = CW_jsform || {};
/* turns on/off debug mode for this script
 */
CW_jsform.DebugMode = false;
/* Checks if a string contains valid data and returns boolean.
 */
CW_jsform._strIsBad = function (aStr) {
  return (CW_jsutils.isNull(aStr) || 0 === aStr.length || "" === aStr);
};
/* Checks if a string representing user's input starts with a forbidden character and
 * returns boolean.
 */
CW_jsform._firstCharIsBad = function (aStr) {
  if (this._strIsBad(aStr)) {
    return true;
  }
  var set = new Set([".", "/", "\\"]);
  return set.has(aStr.charAt(0));
};
/* Checks if a filename has a valid extenstion and returns boolean.
 */
CW_jsform._fileExtIsGood = function (aFileName) {
  if (this._strIsBad(aFileName) || this._firstCharIsBad(aFileName)) {
    return false;
  }
  var ext = aFileName.substr(aFileName.lastIndexOf(".") + 1);
  var set = new Set(["cpp", "cc", "c", "h", "hh", "hpp", "in", "mkf", "sh", "txt"]);
  return set.has(ext);
};
/* A convenience method which combines calls to _firstCharIsBad(),
 * _strIsBad() and _fileExtIsGood() to check if given filename is valid
 * and returns boolean.
 */
CW_jsform._fileNameIsGood = function (aFileName) {
  aFileName = aFileName.trim();
  var nameIsBad = this._strIsBad(aFileName) || this._firstCharIsBad(aFileName);
  return nameIsBad ? false : this._fileExtIsGood(aFileName);
};
/* Reads from the main form base name of the current source file.
 */
CW_jsform._getCurrentFileName = function () {
  return mainForm.fileNameInput.value;
};
/* Writes to the main form base name of the current source file.
 */
CW_jsform._setCurrentFileName = function (aBaseName) {
  mainForm.fileNameInput.value = aBaseName;
  document.getElementById('editorlabelID').value = aBaseName;
};
/* Reads from the main form base name of the current makefile.
 * Originally this function read from the main form name of the lastly executed makefile.
 */
CW_jsform._getLastMakefileName = function () {
  return mainForm.makefileNameInput.value;
};
/* Writes to the main form base name of the current makefile.
 * Originally this function wrote to the main form name of the lastly executed makefile.
 */
CW_jsform._setLastMakefileName = function (aName) {
  mainForm.makefileNameInput.value = aName;
};
/* Reads from the main form base name of the current executable file to be used for testing.
 * Originally this function read from the main form name of the lastly tested executable file.
 */
CW_jsform._getLastExecfileName = function () {
  return mainForm.execfileNameInput.value;
};
/* Writes to the main form base name of the current executable file to used for testing.
 * Originally this function wrote to the main form name of the lastly tested executable file.
 */
CW_jsform._setLastExecfileName = function (aName) {
  mainForm.execfileNameInput.value = aName;
};
/* Sets the current contents of the text editor on the main form.
 */
CW_jsform._setEditorContents = function (aContents) {
  CW_jseditor.setContent(aContents);
};
/* Saves parameters (file name and the editor's contents and scroll position) of the current
 * buffer to restore them the next time the buffer is activated again.
 */
CW_jsform._saveCurrentBufferParams = function () {
  CW_jseditor.saveScrollPos();
  var buffer = gBufferManager.itemAt(gBufferManager.currentIdx());
  buffer.fileContents = CW_jseditor.getContent();
  buffer.fileName = this._getCurrentFileName();
  buffer.line = sessionStorage.line;
  buffer.x = sessionStorage.x;
  buffer.y = sessionStorage.y;
  buffer.height = sessionStorage.height;
};
/* Returns the list of opened buffers in a string form.
 */
CW_jsform._getBufferList = function () {
  var info = "";
  for (i = 0; i < gBufferManager.count(); i++) {
    var obj = gBufferManager.itemAt(i);
    if (CW_jsutils.isNull(obj) || !CW_jsutils.objectDefined(obj)) {
      info = "ERROR **: Failed to get the buffer list";
      if (true === this.DebugMode) {
        console.log("***CWED DEBUGGING LOG***");
        console.log("CW_jsform._getBufferList():undefined buffer #" + i.toString());
        console.log("******END***************");
      }
      break;
    }
    info += "\n" + i.toString() + ": " +
            obj.fileName +
            (obj.fileName === this._getCurrentFileName() ? '*' : '');
  }
  return info;
};
/* Creates a new buffer for a file with given basename and the editor's contents
 */
CW_jsform._addBuffer = function (aBaseName, aContents) {
  // if there are opened buffers we save the params of the current one
  if (gBufferManager.count()) {
    this._saveCurrentBufferParams();
  }
  // An object represening the newly created buffer within the buffer manager.
  // The object's properties include basename and contents of
  // the file, number of the current line, the current scroll position in pixels, and the size of the
  // visible area (minus scrollbars).
  var obj = {
    fileName: aBaseName,
    fileContents: aContents,
    line: 0,
    x: 0,
    y: 0,
    height: 0
  };
  gBufferManager.add(obj);
  gBufferManager.setCurrentIdx(gBufferManager.count() - 1); // making the newly created buffer the current one
  this._setCurrentFileName(aBaseName);
  this._setEditorContents(aContents);
  CW_jseditor.setModified(false);
  // specifying log for the debug mode
  if (true === this.DebugMode) {
    console.log("***CWED DEBUGGING LOG***");
    console.log("CW_jsform._addBuffer():aBaseName=" + aBaseName
            + ":bufidx=" + gBufferManager.currentIdx()
            + ":total=" + gBufferManager.count());
    console.log("******END***************");
  }
  this._writeToOutputPage(aContents.length + " bytes read");
};
/* Activates the text editor
 */
CW_jsform._activateEditor = function (activateOutput = 1) {
  if (1 === activateOutput) {
    this._switchToOutputPage();
  }
  CW_jseditor.activate();
};
/* Activates the OUTPUT page of the form's tabbed page control
 */
CW_jsform._switchToOutputPage = function () {
  document.getElementById("divtab-1").checked = true;
};
/* Sets the contents of the OUTPUT page
 */
CW_jsform._writeToOutputPage = function (aMsg) {
  if (CW_jsutils.objectDefined(mainForm.ideMsgElem)) {
    mainForm.ideMsgElem.value = aMsg;
  }
};
/* Activates the ASM page of the tabbed page control
 */
CW_jsform._switchToAsmPage = function () {
  document.getElementById("divtab-3").checked = true;
};
/* Sets the contents of the ASM page
 */
CW_jsform._writeToAsmPage = function (aMsg) {
  if (CW_jsutils.objectDefined(mainForm.asmElem)) {
    mainForm.asmElem.value = aMsg;
  }
};
/* Activates the VIEW-DIR page of the tabbed page control
 */
CW_jsform._switchToViewDirPage = function () {
  document.getElementById("divtab-5").checked = true;
};
/* Sets the contents of the VIEW-DIR page
 */
CW_jsform._writeToViewDirPage = function (aMsg) {
  if (CW_jsutils.objectDefined(mainForm.viewdirElem)) {
    mainForm.viewdirElem.value = aMsg;
  }
};
/* Activates the BUFFERS page of the tabbed page control
 */
CW_jsform._switchToBuffersPage = function () {
  document.getElementById("divtab-6").checked = true;
};
/* Sets the contents of the BUFFERS page
 */
CW_jsform._writeToBuffersPage = function (aMsg) {
  if (CW_jsutils.objectDefined(mainForm.buffersElem)) {
    mainForm.buffersElem.value = aMsg;
  }
};
/* uses the prior function to write the list of the currently opened buffers to the BUFFERS page */
CW_jsform.printBufferList = function () {
  this._writeToBuffersPage(gBufferManager.count() === 0 ?
          "No opened buffers found" :
          this._getBufferList());
};
/** Activates the FUNCTIONS page of the tabbed page control
 */
CW_jsform._switchToFunctionsPage = function () {
  document.getElementById("divtab-4").checked = true;
};
/* Specifies the message to appear in the OUTPUT page when user
 * cancels an operation
 */
CW_jsform._onCancelled = function (aMsg) {
  this._writeToOutputPage(aMsg);
  this._activateEditor();
};
/* Specifies the message to appear in the OUTPUT page on internal error
 */
CW_jsform._onFailed = function (aMsg) {
  this._writeToOutputPage(aMsg);
  this._activateEditor();
};
/* Returns relative path to the directory with PHP scripts serving Ajax requests
 */
CW_jsform._getAjaxDir = function () {
  return "../ajax/";
};
/* Returns relative path to the directory with service PHP scripts
 */
CW_jsform._getServiceDir = function () {
  return "../service/";
};
/* goes to the editor's line which contains the item selected
 * in the FUNCTIONS page
 */
CW_jsform.symbolSearch = function () {
  if (!document.getElementById("divtab-4").checked) {
    return false;
  }
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found");
    this._activateEditor();
    return false;
  }
  var txtarea = document.getElementById("navigatorElemId");
  var start = txtarea.selectionStart;
  var finish = txtarea.selectionEnd;

  if (start !== finish) {
    var sel = txtarea.value.substring(start, finish);
    var no = CW_jseditor.findLineByString(sel);
    if (no !== -1) {
      CW_jseditor.jumpToLine(no);
    } else {
      this._writeToOutputPage("ERROR **: Symbol not found");
    }
    this._activateEditor();
  }
};
CW_jsform._writeToLog = function (txt) {
  if (true === this.DebugMode) {
    console.log("***CWED DEBUGGING LOG***");
    console.log(txt);
    console.log("******END***************");
  }
};
/* Invokes PHP script for creating a project and returns boolean. Params include login directory where the project
 * is to be created and the project's name.
 */
CW_jsform._createProject = function (dirName, projectName) {
  /*if (CW_jsutils.isNull(resp)) {
    this._onCancelled("Cancelled.");
    return false;
  }*/
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform._createProject():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Creating a project...");
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      if (!CW_jsutils.isNull(obj.responseText)) {
        CW_jsform._writeToOutputPage(obj.responseText);
      } else {
        CW_jsform._onFailed("ERROR **: Failed to create a project.");
      }
    }
  };
  var res = CW_jsutils.sendAjaxPost(obj,
          this._getAjaxDir() + "cwnewproj.ajx.php",
          "dirpath=" + encodeURIComponent(dirName) +
          "&project_name=" + encodeURIComponent(projectName.trim()));
  this._activateEditor();
  return res;
};
/* Invokes PHP script for dropping a project and returns boolean. Params include login directory where the project
 * is located and the project's name.
 */
CW_jsform._dropProject = function (dirName, projectName) {
  /*if (CW_jsutils.isNull(resp)) {
    this._onCancelled("Cancelled.");
    return false;
  } */
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform._dropProject():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Dropping a project...");
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwdelproj.ajx.php?filepath=" + encodeURIComponent(dirName + '/' + projectName.trim());
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Invokes a PHP script for creating a new file in the specified login directory and with
 * given basename and returns boolean. */
CW_jsform._createFile = function (dirName, basename) {
  if (CW_jsutils.isNull(basename)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  basename = basename.trim();
  if (!this._fileNameIsGood(basename)) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  if (gBufferManager.findByName(basename) > -1) {
    this._onFailed("ERROR **: The file already opened");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform._createFile():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Creating a file...");
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      if (!CW_jsform._strIsBad(obj.responseText)) {
        var contents = obj.responseText;
        CW_jsform._addBuffer(basename, contents);
        CW_jsform.printBufferList();
      } else {
        CW_jsform._onFailed("ERROR **: Failed to create file.");
      }
    }
  };
  var res = CW_jsutils.sendAjaxPost(obj,
          this._getAjaxDir() + "cwnewfile.ajx.php",
          "filepath=" + encodeURIComponent(dirName + '/' + basename));
  this._activateEditor();
  return res;
};
/* Invokes a PHP script for opening an existing file in the specified login directory and with
 * given basename and returns boolean. */
CW_jsform._openFile = function (dirName, basename) {
  if (CW_jsutils.isNull(basename)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  basename = basename.trim();
  if (!this._fileNameIsGood(basename)) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  if (gBufferManager.findByName(basename) > -1) {
    this._onFailed("ERROR **: The file already opened");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform._openFile():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Opening a file...");
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      if (!CW_jsform._strIsBad(obj.responseText)) {
        var contents = obj.responseText;
        CW_jsform._addBuffer(basename, contents);
        CW_jsform.printBufferList();
      } else {
        CW_jsform._onFailed("ERROR **: Failed to open file. Make sure it exists and is readable.");
      }
    }
  };
  var res = CW_jsutils.sendAjaxPost(obj,
          this._getAjaxDir() + "cwopen.ajx.php",
          "filepath=" + encodeURIComponent(dirName + '/' + basename));
  this._activateEditor();
  return res;
};
/* Invokes PHP script for dropping an existing file in the specified login directory and with
 * given basename and returns boolean. */
CW_jsform._dropFile = function (dirName, basename) {
  if (CW_jsutils.isNull(basename)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  basename = basename.trim();
  if (gBufferManager.findByName(basename) !== -1) {
    this._onFailed("ERROR **: An opened file cannot be dropped.");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform._dropFile():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Dropping a file...");
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwdrop.ajx.php?filepath=" + encodeURIComponent(dirName + '/' + basename);
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Invokes PHP script for creating a TAR archive out of user-specified files and returns boolean.
 * Params include the login directory where the archive and user files are located,
 * path to the tar archiver and list of the files to archive separated by space.
 * Name of the created tar file is cwed.tar.
 */
CW_jsform._tarFile = function (dirName, tarPath, files) {
  if (CW_jsutils.isNull(files)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  if (this._strIsBad(files)) {
    this._onFailed("ERROR **: Invalid file names.");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform._tarFile():ajax object is null!");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwtar.ajx.php?files=" +
          encodeURIComponent(files) +
          "&dirname=" +
          encodeURIComponent(dirName) +
          "&tarpath=" +
          encodeURIComponent(tarPath);
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Invokes PHP script for downloading a file and returns boolean.
 * Params include the login directory where the file is located and
 * the file's base name.
 */
CW_jsform._downloadFile = function (dirName, fileName) {
  if (CW_jsutils.isNull(fileName)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  fileName = fileName.trim();
  this._writeToOutputPage("Downloading a file...");
  var qry = this._getServiceDir() + "cwdownload.srv.php?filepath=" + encodeURIComponent(dirName + '/' + fileName);
  window.open(qry, "_blank");
  this._activateEditor();
  return res;
};
/* Invokes a PHP script for emailing a file as an attachment and returns boolean. Params include
 * the login directory where the file is stored, basename of the file, and the target email address.
 */
CW_jsform._mailFile = function (dirName, attachment, address)
{
  if (CW_jsutils.isNull(attachment) || CW_jsutils.isNull(address)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  if (this._strIsBad(attachment)) {
    this._onFailed("ERROR **: Invalid attachment.");
    return false;
  }
  if (this._strIsBad(address)) {
    this._onFailed("ERROR **: Invalid email address.");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object");
    this._writeToLog("CW_jsform._mailFile():ajax object is null!");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwmail.ajx.php?address=" +
          encodeURIComponent(address) +
          "&attachment=" +
          encodeURIComponent(dirName + "/" + attachment);
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* switches to buffer whose ordinal no is specified in the nextIdx param */
CW_jsform._switchToBufferByIndex = function (dirName, nextIdx) {
  if ((nextIdx < 0) || (nextIdx >= gBufferManager.count())) {
    this._onFailed("ERROR **: Invalid buffer number.");
    return false;
  }
  if (nextIdx === gBufferManager.currentIdx()) {
    this._onFailed("ERROR **: The buffer already opened.");
    return false;
  }
  var prevItem = gBufferManager.itemAt(gBufferManager.currentIdx());
  this._saveCurrentBufferParams(prevItem);
  var nextItem = gBufferManager.itemAt(nextIdx);
  this._setCurrentFileName(nextItem.fileName);
  this._setEditorContents(nextItem.fileContents);
  gBufferManager.setCurrentIdx(nextIdx);
  CW_jseditor.setScrollPos(nextItem.line, nextItem.height, nextItem.x);
  this._writeToOutputPage("Switched to " + nextItem.fileName);
  this.printBufferList();
  this._switchToBuffersPage();
  this._activateEditor(0);
  return true;
};
/* Handles clicking the PROJECT-NEW item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onProjectNewMenuItemClick = function (dirName) {
  brompt(
          {
            title: "Name of the project:",
            type: 'info',
            okButtonText: 'Create',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (projectName) {
              CW_jsform._createProject(dirName, projectName);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the PROJECT-DROP item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onProjectDropMenuItemClick = function (dirName) {
  brompt(
          {
            title: "Name of the project:",
            type: 'info',
            okButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (projectName) {
              CW_jsform._dropProject(dirName, projectName);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-NEW item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileNewClick = function (dirName) {
  if (gBufferManager.count() >= 10) {
    this._onFailed("ERROR **: Limit of opened buffers reached.");
    return false;
  }
  if (gBufferManager.count() && CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var defaultName = this._getCurrentFileName();
  brompt(
          {
            title: "Basename of the file:",
            type: 'info',
            okButtonText: 'Open',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (basename) {
              CW_jsform._createFile(dirName, basename);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-OPEN item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileOpenClick = function (dirName) {
  if (gBufferManager.count() >= 10) {
    this._onFailed("ERROR **: Limit of opened buffers reached.");
    return false;
  }
  if (gBufferManager.count() && CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var defaultName = this._getCurrentFileName();
  brompt(
          {
            title: "Basename of the file:",
            type: 'info',
            okButtonText: 'Open',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (basename) {
              CW_jsform._openFile(dirName, basename);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-SAVE item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileSaveClick = function (dirName, logIt = false) {
  if (!gBufferManager.count()) {
    this._onFailed("ERROR **: No buffer found.");
    return false;
  }
  var fileName = this._getCurrentFileName();
  if (!this._fileNameIsGood(fileName) && (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onFileSaveClick():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Saving a file...");
  var str = encodeURIComponent(CW_jseditor.getContent());
  var fileName = encodeURIComponent(dirName + "/" + fileName);
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      if (CW_jsutils.objectDefined(logIt) && true === logIt) {
        CW_jsform._writeToOutputPage(obj.responseText);
        CW_jseditor.setModified(false);
      }
    }
  };
  var res = CW_jsutils.sendAjaxPost(obj,
          this._getAjaxDir() + "cwsave.ajx.php",
          "filename=" + fileName + "&data=" + str);
  if (CW_jsutils.objectDefined(logIt) && true === logIt) {
    this._activateEditor();
  }
  return res;
};
/* Handles clicking the FILE-DROP item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileDropClick = function (dirName) {
  var defaultName = this._getCurrentFileName();
  brompt(
          {
            title: "Basename of the file:",
            type: 'info',
            okButtonText: 'Drop',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (basename) {
              CW_jsform._dropFile(dirName, basename);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-VIEWDIR item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileViewdirClick = function (dirName) {
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onFileViewdirClick():ajax object is null!");
    return false;
  }
  this._writeToOutputPage("Viewing the login directory...");
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      var list = obj.responseText.trim();
      var msg = "DIR contents:\n";
      if (!CW_jsform._strIsBad(list)) {
        var arr = list.split(':');
        arr.forEach(function (elem) {
          msg += "\n" + elem;
        });
        CW_jsform._writeToViewDirPage(msg);
        CW_jsform._switchToViewDirPage();
      } else {
        CW_jsform._writeToOutputPage("ERROR **: Failed to view the directory");
      }
    }
  };
  var res = CW_jsutils.sendAjaxGet(obj,
          this._getAjaxDir() + "cwviewdir.ajx.php?dirname=" +
          encodeURIComponent(dirName));
  this._activateEditor();
  return res;
};
/* Handles clicking the FILE-TAR item of the main form's menu and
 * returns boolean. Parameters specify path to the login directory,
 * and path to the Tar archiver.
 */
CW_jsform.onFileTarClick = function (dirName, tarPath) {
  if (gBufferManager.count() && CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  this._writeToOutputPage("Archiving...");
  brompt(
          {
            title: "Basenames of the files: ",
            type: 'info',
            okButtonText: 'TAR',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (files) {
              CW_jsform._tarFile(dirName, tarPath, files);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-MAIL item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileMailClick = function (dirName) {
  if (gBufferManager.count() && CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  this._writeToOutputPage("EMailing...");
  brompt(
          {
            title: "Basename of the file and email address:",
            type: 'info',
            okButtonText: 'MAIL',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (data) {
              if (CW_jsutils.isNull(data) || CW_jsform._strIsBad(data) || -1 === data.indexOf(',')) {
                CW_jsform._onFailed("Invalid data.");
              } else {
                tokens = data.split(",");
                res = CW_jsform._mailFile(dirName, tokens[0].trim(), tokens[1].trim());
                if (!res) {
                  CW_jsform._onFailed("Failed to send data.");
                }
              }
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-DOWNLOAD item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileDownloadClick = function (dirName) {
  if (gBufferManager.count() && CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  brompt(
          {
            title: "Base name of the file:",
            type: 'info',
            okButtonText: 'Open',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (basename) {
              if (CW_jsutils.isNull(basename) || CW_jsform._strIsBad(basename)) {
                CW_jsform._onFailed("Invalid name.");
              } else {
                CW_jsform._downloadFile(dirName, basename);
              }
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the FILE-LOGOUT item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onFileLogoutClick = function (aDirName) {
  if (gBufferManager.count() && CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  location.replace("../service/cwlogout.srv.php?toLogin=1");
};
/* Handles clicking the BUFFER->NEXT item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onBufferNextClick = function (dirName) {
  if (gBufferManager.count() <= 1) {
    this._onFailed("ERROR **: No buffers found.");
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var prevItem = gBufferManager.itemAt(gBufferManager.currentIdx());
  this._saveCurrentBufferParams(prevItem);
  if (gBufferManager.currentIdx() === gBufferManager.count() - 1) {
    var nextIdx = 0;
  } else {
    var nextIdx = (gBufferManager.currentIdx() < gBufferManager.count() - 1) ?
            gBufferManager.currentIdx() + 1 : 0;
  }
  var nextItem = gBufferManager.itemAt(nextIdx);
  this._setCurrentFileName(nextItem.fileName);
  this._setEditorContents(nextItem.fileContents);
  gBufferManager.setCurrentIdx(nextIdx);
  CW_jseditor.setScrollPos(nextItem.line, nextItem.height, nextItem.x);
  this._writeToOutputPage("Switched to " + nextItem.fileName);
  this.printBufferList();
  this._switchToBuffersPage();
  this._activateEditor(0);
  return true;
};
/* Handles clicking the BUFFER->SWITCH item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onBufferSwitchClick = function (dirName) {
  if (gBufferManager.count() <= 1) {
    this._onFailed("ERROR **: No buffers found.");
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  brompt(
          {
            title: "The buffer #:",
            type: 'info',
            okButtonText: 'OK',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (resp) {
              if (CW_jsutils.isNull(resp) || !CW_jsutils.isNumber(resp)) {
                this._onFailed("Invalid number.");
              } else {
                CW_jsform._switchToBufferByIndex(dirName, parseInt(resp));
              }

            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  return true;
};
/* Handles clicking the EDIT->FUNCTIONS item of the main form's menu.
 */
CW_jsform.updateCodeNavigator = function () {
  var oldItems = CW_jseditor.getFunctionList();
  oldItems.sort();
  var newItems = [];
  var itemLen = oldItems.length;
  for (var i = 0; i < itemLen; ++i) {
    var s = oldItems[i].trim();
    if (!newItems.includes(s)) {
      newItems.push(s);
    }
  }
  mainForm.navigatorElem.value = newItems.join("\n");
  this._switchToFunctionsPage();
};
/* Handles clicking the TEST->LINT item of the main form's menu and
 * returns boolean. Parameters specify path to the login directory and
 * path to the gcc compiler.
 */
CW_jsform.onTestLintClick = function (dirName, gccPath) {
  this._writeToOutputPage("Linting...");
  if (!gBufferManager.count()) {
    this._onFailed("ERROR **: No buffer to found.");
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var fileName = this._getCurrentFileName();
  if (!this._fileNameIsGood(fileName) && (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (false === CW_jsutils.objectDefined(obj)) {
    this._onFailed("Failed to create a request object.");
    this._writeToLog("CW_jsform.onTestLintClick():ajax object is null!");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwlint.ajx.php?srcpath=" +
          encodeURIComponent(dirName + "/" + fileName) +
          "&gcc_path=" +
          encodeURIComponent(gccPath);
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Handles clicking the TEST->COMPILE item of the main form's menu and
 * returns boolean. Parameters specify path to the login directory,
 * path to the gcc compiler and compilation options.
 */
CW_jsform.onTestCompileClick = function (dirName, gccPath, gccOptions) {
  this._writeToOutputPage("Compiling...");
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var fileName = this._getCurrentFileName();
  var resp = fileName + ".out";
  CW_jsform._setLastExecfileName(resp);
  var execPath = encodeURIComponent(dirName + "/" + resp);
  var obj = CW_jsutils.createAjaxObject();
  if (false === CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onTestCompileClick():ajax object is null!");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwcompile.ajx.php?srcpath=" +
          encodeURIComponent(dirName + "/" + fileName) +
          "&main_options=" +
          encodeURIComponent(gccOptions) +
          "&gcc_path=" +
          encodeURIComponent(gccPath) +
          "&execpath=" +
          execPath;
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Handles clicking the TEST->ASM item of the main form's menu and
 * returns boolean. Parameters specify path to the login directory
 * and path to the gcc compiler.
 */
CW_jsform.onTestAsmClick = function (dirName, gccPath) {
  this._writeToOutputPage("Compiling to ASM...");
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (false === CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onTestAsmClick():ajax object is null!");
    return false;
  }
  var fileName = this._getCurrentFileName();
  if (!this._fileNameIsGood(fileName) && (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToAsmPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwasm.ajx.php?srcpath=" +
          encodeURIComponent(dirName + "/" + fileName) + "&gcc_path=" +
          encodeURIComponent(gccPath) + "&asmpath=" +
          encodeURIComponent(dirName + "/" + fileName + ".s");
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._switchToAsmPage();
  return res;
};
/* Handles clicking the TEST->MAKE item of the main form's menu and
 * returns boolean. Parameters specify path to the login directory
 * and path to the Make utility.
 */
CW_jsform.onTestMakeClick = function (dirName, makePath) {
  this._writeToOutputPage("Making...");
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var makeFileName = this._getLastMakefileName();
  if (CW_jsutils.isNull(makeFileName)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  if (this._strIsBad(makeFileName)) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onTestMakeClick():ajax object is null!");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwmake.ajx.php?filename=" +
          encodeURIComponent(makeFileName) +
          "&dirname=" +
          encodeURIComponent(dirName) +
          "&makepath=" +
          encodeURIComponent(makePath);
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Handles clicking the TEST->RUN item of the main form's menu and
 * returns boolean. Parameters specify path to the login directory and
 * path to the input file for tested executable.
 */
CW_jsform.onTestRunClick = function (dirName, inputFilePath) {
  this._writeToOutputPage("Testing...");
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  var resp = this._getLastExecfileName();
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onTestRunClick():ajax object is null!");
    return false;
  }
  if (CW_jsutils.isNull(resp)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  if (this._strIsBad(resp)) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwtest.ajx.php?execpath=" +
          encodeURIComponent(dirName + "/" + resp) +
          "&inputfilepath=" +
          encodeURIComponent(inputFilePath) +
          "&inputdata=" +
          encodeURIComponent(mainForm.inputTextArea.value);
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Handles clicking the TEST->TERMINAL item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory.
 */
CW_jsform.onTestTerminalClick = function (dirName) {
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  if (CW_jseditor.isModified()) {
    this._onFailed("ERROR **: Current buffer modified");
    return false;
  }
  var resp = this._getLastExecfileName();
  if (CW_jsutils.isNull(resp)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  window.open("../forms/cwterm.frm.php?dirname=" + encodeURIComponent(dirName) +
          "&execname=" + encodeURIComponent(resp),
          "_blank",
          "height=500,width=900,scrollbars=1,location=no,menubar=no,resizable=1,status=no,toolbar=no").focus();

  return true;
};
/* Handles clicking the DEBUG->BACKTRACE item of the main form's menu and
 * returns boolean. Parameters specify path to the GDB debugger,
 * path to the login directory storing the tested executable,
 * path to the input file for the tested executable and path
 * to the batch file listing the commands for debugging.
 */
CW_jsform.onTestDebugClick = function (gdbPath, execDir, inputFile, batchFile) {
  this._writeToOutputPage("Debugging...");
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  var obj = CW_jsutils.createAjaxObject();
  if (!CW_jsutils.objectDefined(obj)) {
    this._onFailed("ERROR **: Failed to create a request object.");
    this._writeToLog("CW_jsform.onTestDebugClick():ajax object is null!");
    return false;
  }
  var basename = this._getLastExecfileName();
  if (CW_jsutils.isNull(basename)) {
    this._onCancelled("Cancelled.");
    return false;
  }
  if (this._strIsBad(basename)) {
    this._onFailed("ERROR **: Invalid file name.");
    return false;
  }
  var inputData = encodeURIComponent(mainForm.inputTextArea.value);
  obj.onreadystatechange = function () {
    if (4 === obj.readyState) {
      CW_jsform._writeToOutputPage(obj.responseText);
    }
  };
  var qry = this._getAjaxDir() + "cwdebug.ajx.php?gdbpath=" +
          encodeURIComponent(gdbPath) +
          "&execpath=" +
          encodeURIComponent(execDir + "/" + basename) +
          "&inputname=" +
          encodeURIComponent(inputFile) +
          "&batchname=" +
          encodeURIComponent(batchFile) +
          "&inputdata=" +
          inputData;
  var res = CW_jsutils.sendAjaxGet(obj, qry);
  this._activateEditor();
  return res;
};
/* Handles clicking the SESSION-SET MAKEFILE item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory. Originally
 * the item was located under the TEST menu.
 */
CW_jsform.onTestSetMakefileClick = function (dirName) {
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  brompt(
          {
            title: "Basename of the makefile:",
            type: 'info',
            okButtonText: 'Open',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (aName) {
              CW_jsform._setLastMakefileName(aName);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  this._activateEditor();
  return true;
};
/* Handles clicking the SESSION-GET MAKEFILE item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory. Originally
 * the item was located under the TEST menu.
 */
CW_jsform.onTestGetMakefileClick = function (dirName) {
  var fileName = this._getLastMakefileName();
  this._writeToOutputPage(this._strIsBad(fileName) ? "ERROR **: Makefile not set" : fileName);
  this._switchToOutputPage();
};
/* Handles clicking the SESSION-SET EXEC item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory. Originally
 * the item was located under the TEST menu.
 */
CW_jsform.onTestSetExecutableClick = function (dirName) {
  if (!gBufferManager.count() || (-1 === gBufferManager.currentIdx())) {
    this._onFailed("ERROR **: No current buffer found.");
    this._activateEditor();
    return false;
  }
  brompt(
          {
            title: "Basename of the executable: (default is " + CW_jsform._getLastExecfileName() + ")",
            type: 'info',
            okButtonText: 'Open',
            cancelButtonText: 'Cancel',
            escapable: false,
            onConfirm: function (execName) {
              CW_jsform._setLastExecfileName(execName);
            },
            onCancel: function () {
              CW_jsform._onCancelled("Cancelled.");
            }
          });
  this._activateEditor();
  return true;
};
/* Handles clicking the SESSION-GET EXEC item of the main form's menu and
 * returns boolean. Parameter specifies path to the login directory. Originally
 * the item was located under the TEST menu.
 */
CW_jsform.onTestGetExecutableClick = function (dirName) {
  var fileName = this._getLastExecfileName();
  this._writeToOutputPage(this._strIsBad(fileName) ? "ERROR **: Executable not set" : fileName);
  this._switchToOutputPage();
};
/* Deprecated function for showing a message box
 */
CW_jsform.showAlert = function (aMsg) {
  window.alert(this._strIsBad(aMsg) ? "ERROR **: (NULL) message" : aMsg);
  this._activateEditor();
};
/* Deprecated function for showing an input dialog with given prompt and default value.
 * Returns user's input which is NULL when user cancelled the prompt.
 */
CW_jsform.showPrompt = function (aPrompt, aDefVal) {
  return window.prompt(aPrompt, aDefVal);
};
/* deprectated confirmation dialog */
CW_jsform.askConfirm = function (aMsg) {
  return window.confirm(aMsg);
};
/* a callback function invoked automatically when the contents of the
 * gets modified
 */
CW_jsform.handleModified = function (aFlag) {
  mainForm.bufferStatus.value = true === aFlag ? "Modified" : "Saved";
};