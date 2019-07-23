<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwselect.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Encapsulates the <select> HTML form element.
 */
class CWLIB_Select extends CWLIB_HtmlObject
{
  /* value of the class attribute */
  protected $mCssClass;
  /* value of the title attribute */
  protected $mTitle;
  /* caption to be inserted before the element */
  protected $mLabel;
  /* value of the onchange attribute */
  protected $mOnChange;
  /*  Default constructor. The parameters include value of the type attribute of the element,
    value of the id attribute, value of the name attribute, value of the class attribute,
    value of the title attribute, text on the caption to be inserted before the element and
   * value of the onchange attribute
   */
  public function __construct($aId, $aName, $aCssClass, $aTitle, $aLabel, $aOnChange)
  {
    $this->setId($aId);
    $this->setName($aName);
    $this->setCssClass($aCssClass);
    $this->setTitle($aTitle);
    $this->setLabel($aLabel);
    $this->setOnChange($aOnChange);
  }
  /* Sets the value of the type attribute.
   */
  public function setType($aValue)
  {
    $this->mType = $aValue;
  }
  /* Sets the value of the class attribute.
   */
  public function setCssClass($aValue)
  {
    $this->mCssClass = $aValue;
  }
  /* Sets the value of the type attribute.
   */
  public function setTitle($aValue)
  {
    $this->mTitle = $aValue;
  }
  /* Sets the value of the label attribute.
   */
  public function setLabel($aLabel)
  {
    $this->mLabel = $aLabel;
  }
  /* sets the value of the onchange attribute */
  public function setOnChange($aOnChange)
  {
    $this->mOnChange = $aOnChange;
  }
  /* Returns HTML for the element.
   */
  public function generateHtml()
  {
    return sprintf("%s <select name='%s' id='%s' title='%s' class='%s' onchange='%s'></select>", $this->mLabel, $this->mName, $this->mId, $this->mTitle, $this->mCssClass, $this->mOnChange);
  }
}
?>
