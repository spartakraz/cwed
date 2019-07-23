<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwhtmlobject.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Encapsulates a generic form element.
 */
abstract class CWLIB_HtmlObject
{
  /* Value of the element's ID attribute. */
  protected $mId;
  /* Value of the name attribute. */
  protected $mName;
  /* Sets the value of the ID attribute.
   */
  public function setId($aValue)
  {
    $this->mId = $aValue;
  }
  /* Gets the value of the ID attribute.
   */
  public function setName($aValue)
  {
    $this->mName = $aValue;
  }
  /* Use this function to return HTML code for the form element.
   */
  abstract public function generateHtml();
}
?>
