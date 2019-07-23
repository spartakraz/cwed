<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwlabel.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/*  Generates HTML for <label> form element. Params include
  value of the class attribute, value of the title attribute
  and the text to be displayed by the element.
 */
function CWLIB_labelGenerateHtml($class, $title, $value)
{
  return sprintf("<label class='%s' title='%s'>%s</label>", $class, $title, $value);
}
?>
