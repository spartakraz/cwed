<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwhtmlcontainer.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Generic container for HTML form elements.
 */
abstract class CWLIB_HtmlContainer
{
  /*  Use this function to output HTML code of an object which
    represent a HTML form element and is contained within CW_HtmlContainer.
   */
  protected function printEmbeddedObject(&$aObject)
  {
    echo $aObject->generateHtml();
  }
  /*  Use this function to return HTML code for the whole container with all elements
    contained within it.
   */
  abstract public function generateHtml();
}
?>