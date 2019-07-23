/* MANAGING THE APPLICATION'S WINDOW
 */
window.onload = function () {
  if (typeof sessionStorage === "undefined" || sessionStorage === null) {
    alert("sessionStorage not found");
  }
};
window.addEventListener("beforeunload", function (event) {
  window.location.href = "cwlogout.php";
}, false);
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
};
/* shows a dropdown box with items of given menu element */
showMenuElement = function (elem) {
  elem.classList.toggle("show");
};
/* hides a dropdown box with items of given menu element */
hideMenuElement = function (elem) {
  elem.classList.remove("show");
};
/* returns distance in pixels between left edges of dropdown boxes of
 * two neighboring menu elements
 */
getMenuDistance = function () {
  return 90;
};
/* handles clicking menu buttons */
onDropDownClick = function (aLeft, aID)
{
  document.getElementById(aID).style.left = aLeft + "px";
  var dropdowns = document.getElementsByClassName("dropdown-content");
  var i;
  for (i = 0; i < dropdowns.length; i++) {
    var dropdown = dropdowns[i];
    if (dropdown.id === aID) {
      showMenuElement(dropdown);
    } else {
      hideMenuElement(dropdown);
    }
  }
};
/* reaction to click on FILE menu element */
onFileDropDownClick = function () {
  onDropDownClick("1", "fileDropdown");
};
/* reaction to click on BUFFER menu element */
onBufferDropDownClick = function () {
  onDropDownClick((getMenuDistance() + 1).toString(), "bufferDropdown");
};
/* reaction to click on EDIT menu element */
onEditDropDownClick = function () {
  onDropDownClick(((getMenuDistance() * 2) + 1).toString(), "editDropdown");
};
/* reaction to click on SESSION menu element */
onSessionDropDownClick = function () {
  onDropDownClick(((getMenuDistance() * 3) + 1).toString(), "sessionDropdown");
};
/* reaction to click on TEST menu element */
onTestDropDownClick = function () {
  onDropDownClick(((getMenuDistance() * 4) + 1).toString(), "testDropdown");
};
/* reaction to click on DEBUG menu element */
onDebugDropDownClick = function () {
  onDropDownClick(((getMenuDistance() * 5) + 1).toString(), "debugDropdown");
};
// reaction to click on PROJECT menu element
onProjectDropDownClick = function () {
  onDropDownClick(((getMenuDistance() * 6) + 1).toString(), "projectDropdown");
};
addToSelect = function(aBox, aValue, aHTML) {
  var opt = document.createElement("option");
  opt.value = aValue;
  opt.innerHTML = aHTML;
  aBox.appendChild(opt);   
};
fillSnippetBox = function() {
  var box = mainForm.snippetbox;
  addToSelect(box, "#define NAME value", "#define");
  addToSelect(box, "#include<header.h>", "#include");
  addToSelect(box, "int var;", "int");
  addToSelect(box, 'printf("%d", n)', "printf()");
};
