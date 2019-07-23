/*  STUFF USED BY THE APPLICATION'S BUILT-IN TERMINAL
 *  -------------------------------------------------
 */
/* quits the terminal on receiving the QUIT command (":q")
 */
function TERM_stopScript() {
  $(".stdin").hide();
  window.close();
}
/* checks if given command is the QUIT command
 */
function TERM_isLogout(cmd) {
  return (cmd.indexOf(":q") !== -1);
}
/* sets focus on the console's input area
 */
function TERM_activateStdin() {
  $(".stdin").focus();
}
/* makes the input area editable
 */
function TERM_turnOffReadonlyForStdin() {
  $(".stdin").removeAttr("readonly");
}
/* writes given string to the input area
 */
function TERM_writeToStdin(str) {
  $(".stdin").val(str);
}
/* writes given string to the console's output area
 */
function TERM_writeToStdout(output) {
  $(".stdout").before(output);
}
/*  Sends user's input to the process running in the terminal.
 Params include the input and flag shown whether or not the input area must be cleared
 */
function TERM_sender(cmd, clear) {
  $.post("cwterm.frm.php", {
    stdin: cmd
  }, function (data) {
    return true;
  });
  if (clear == true) {
    TERM_writeToStdin("");
  }
  TERM_activateStdin();
}
/* displays given output received from the process
 */
function TERM_receiver(output) {
  if ("" != output && null != output) {
    output = output.replace(/[\u001b\u009b][[()#;?]*(?:[0-9]{1,4}(?:;[0-9]{0,4})*)?[0-9A-ORZcf-nqry=><]/g, "");
  }
  TERM_writeToStdout(output);
  TERM_turnOffReadonlyForStdin();
  TERM_activateStdin();
  window.scrollTo(0, document.body.scrollHeight);
  if (TERM_isLogout(output)) {
    TERM_stopScript();
  }
}
/* initalizes the console's GUI
 */
function term_init() {
  $(".stdin").keydown(function (e) {
    if ($(this).is("[readonly]"))
      return false;
    code = e.keyCode ? e.keyCode : e.which;
    if (code.toString() == 13) {
      TERM_sender(this.value, true);
    }
  }),
          TERM_writeToStdin("");
  TERM_activateStdin();
  $("body").click(function () {
    TERM_activateStdin();
  });
}
