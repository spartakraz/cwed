/* INTERFACE TO TEXT EDITOR ON THE MAIN FORM
 */
var CW_jseditor = CW_jseditor || {};
/* An editor instance bound to a textarea DOM element
 */
CW_jseditor.editor = {};
/* Internal flag indicating whether the editor's contents
 * have been modified.
 */
CW_jseditor._modified = false;
/* Returns a configuration object for the editor instance
 */
CW_jseditor._getDefaultOptions = function () {
  return {
    lineNumbers: true,
    lineWrapping: true,
    autoIndent: true,
    autoCloseBrackets: true,
    matchBrackets: true,
    indentWithTabs: true,
    indentUnit: 4,
    styleActiveLine: true,
    autofocus: true,
    enterMode: "indent",
    tabMode: "indent",
    mode: "text/x-c++src",
    keyMap: "default",
    theme: "neat"
  };
};
/* Returns custom keymaps for the editor instance
 */
CW_jseditor._getExtraKeyBindings = function () {
  return {
    "Ctrl-K": function (cm) {
      cm.execCommand("killLine");
    },
    "Ctrl-Space": "autocomplete"
  };
};
/* Initializes the editor instance and binds it to the textarea DOM element
 *  whose ID attribute is editorId
 */
CW_jseditor.init = function () {
  this.editor = CodeMirror.fromTextArea(editorId, this._getDefaultOptions());
  this.editor.on('change', function (cm) {
    CW_jseditor.setModified(true);
  });
  CodeMirror.commands.autocomplete = function (cm) {
    cm.showHint({hint: CodeMirror.hint.anyword});
  }
  this.editor.setOption("extraKeys", this._getExtraKeyBindings());
  document.getElementById("editorId").style.visibility = "visible";
  this.setModified(false);
};
/* function to be called when the editor's contents get modified
 */
CW_jseditor.onModifyCallback = function () {};
/* Returns the value of the internal flag indicating whether the editor's contents
 * have been modified.
 */
CW_jseditor.isModified = function () {
  return this._modified;
};
/* Sets the value of the internal flag indicating whether the editor's contents
 * have been modified.
 */
CW_jseditor.setModified = function (flag) {
  this._modified = flag;
  this.onModifyCallback(flag);
};
/* Refreshes the editor's contents
 */
CW_jseditor.refresh = function () {
  this.editor.refresh();
};
/* Makes the editor grab a focus
 */
CW_jseditor.setFocus = function () {
  this.editor.focus();
};
/* Activates the editor
 */
CW_jseditor.activate = function () {
  this.setFocus();
};
/* Sets the editor's contents
 */
CW_jseditor.setContent = function (str) {
  this.editor.setValue(str);
  this.setModified(false);
};
/* Returns the editor's contents
 */
CW_jseditor.getContent = function () {
  return this.editor.getValue();
};
/* Replaces the current selection with given text
 */
CW_jseditor.insertText = function (aText) {
  this.editor.getDoc().replaceSelection(aText);
};
/* Returns number of the current line
 */
CW_jseditor.getCursorLine = function () {
  return this.editor.getCursor().line;
};
/* Returns total number of lines in the editor
 */
CW_jseditor.getLineCount = function () {
  return this.editor.getDoc().lineCount();
};
/* Invokes the built-in Goto dialog
 */
CW_jseditor.invokeGotoLineDlg = function () {
  this.editor.execCommand("jumpToLine");
};
/* jumps to specified line programmatically as opposed to using built-in dialogs
 */
CW_jseditor.jumpToLine = function (i) {
  var ed = this.editor;
  var top = ed.charCoords({line: i, ch: 0}, "local").top;
  var middleHeight = ed.getScrollerElement().offsetHeight / 2;
  ed.scrollTo(null, top - middleHeight - 5);
  ed.setCursor({line: i, ch: 0});
  this.setFocus();
};
/* Invokes the built-in Search dialog
 */
CW_jseditor.invokeSearchDlg = function () {
  this.editor.execCommand("find");
};
/* returns number of the first line which contains given string
 */
CW_jseditor.findLineByString = function (str) {
  var ed = this.editor;
  var count = ed.lineCount();
  for (var i = this.getCursorLine(); i < count; i++) {
    var contents = ed.getLine(i).trim();
    if (contents.indexOf(str) !== -1) {
      return i;
    }
  }
  ;
  return -1;
};
/* Invokes the built-in Replace dialog
 */
CW_jseditor.invokeReplaceDlg = function () {
  this.editor.execCommand("replace");
};
/* Returns a string array with the list of all function declarations and calls found
 *  in the editor
 */
CW_jseditor.getFunctionList = function () {
  var word = /(operator(?:\s*).+|~?\w+\s*)\(.*\)/g, range = 500;
  var cur = this.editor.getCursor(), curLine = this.editor.getLine(cur.line);
  var end = cur.ch, start = end;
  while (start && word.test(curLine.charAt(start - 1)))
    --start;
  var curWord = start != end && curLine.slice(start, end);
  var list = [], seen = {};
  var re = new RegExp(word.source, "g");
  for (var dir = -1; dir <= 1; dir += 2) {
    var line = cur.line, endLine = Math.min(Math.max(line + dir * range, this.editor.firstLine()), this.editor.lastLine()) + dir;
    for (; line != endLine; line += dir) {
      var text = this.editor.getLine(line), m;
      while (m = re.exec(text)) {
        if (line == cur.line && m[0] === curWord)
          continue;
        if ((!curWord || m[0].lastIndexOf(curWord, 0) == 0) && !Object.prototype.hasOwnProperty.call(seen, m[0])) {
          seen[m[0]] = true;
          list.push(m[0]);
        }
      }
    }
  }
  return list;
};
/* Formats the editor's contents
 */
CW_jseditor.formatCode = function () {
  var count = this.getLineCount();
  for (var i = 0; i < count; i++) {
    this.editor.indentLine(i);
  }
  this.activate();
};
/* Saves the editor's current scroll position: the current cursor's line,
 *  pixel coordinates of the current scroll position and
 *  the size of the visible area (minus scrollbars)
 */
CW_jseditor.saveScrollPos = function () {
  var n = this.getCursorLine();
  sessionStorage.line = (n === this.editor.getDoc().lineCount() - 1) ? n - 1 : n;
  var scroll = this.editor.getScrollInfo();
  sessionStorage.x = scroll.x;
  sessionStorage.y = scroll.y;
  sessionStorage.height = scroll.clientHeight;
};
/* Sets the editor's current scroll position: the cursor's line,
 *  pixel coordinates of the scroll position and the size of the visible area
 *  (minus scrollbars)
 */
CW_jseditor.setScrollPos = function (aLine, aHeight, aX) {
  var posObj = {
    line: aLine,
    ch: 0
  };
  var ed = this.editor;
  ed.setCursor(posObj);
  var coord = ed.charCoords(posObj, "local");
  ed.scrollTo(aX, (coord.top + coord.bottom - aHeight) / 2);
};
