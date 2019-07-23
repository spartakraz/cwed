<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwinput.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Encapsulates the <input> HTML form element.
 */
class CWLIB_Input extends CWLIB_HtmlObject
{
  /* value of the type attribute of the element */
  protected $mType;
  /* value of the class attribute */
  protected $mCssClass;
  /* value of the title attribute */
  protected $mTitle;
  /* text assigned to the value attribute */
  protected $mValue;
  /* caption to be inserted before the element */
  protected $mLabel;
  /*  Default constructor. The parameters include value of the type attribute of the element,
    value of the id attribute, value of the name attribute, value of the class attribute,
    value of the title attribute, text assigned to the value attribute and
    text on the caption to be inserted before the element.
   */
  public function __construct($aType, $aId, $aName, $aCssClass, $aTitle, $aValue, $aLabel)
  {
    $this->setType($aType);
    $this->setId($aId);
    $this->setName($aName);
    $this->setCssClass($aCssClass);
    $this->setTitle($aTitle);
    $this->setValue($aValue);
    $this->setLabel($aLabel);
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
  /* Sets the text for the value attribute.
   */
  public function setValue($aValue)
  {
    $this->mValue = $aValue;
  }
  /* Sets the value of the label attribute.
   */
  public function setLabel($aLabel)
  {
    $this->mLabel = $aLabel;
  }
  /* Returns HTML for the element.
   */
  public function generateHtml()
  {
    return sprintf("%s <input type='%s' name='%s' id='%s' value='%s' title='%s' class='%s'>", $this->mLabel, $this->mType, $this->mName, $this->mId, $this->mValue, $this->mTitle, $this->mCssClass
    );
  }
}
?>
