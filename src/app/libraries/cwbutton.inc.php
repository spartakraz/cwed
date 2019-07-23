<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwbutton.inc.php
  Subpackage:   library
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Represents the <input> HTML form element.
 */
class CWLIB_Button extends CWLIB_HtmlObject
{
  /* value of the class attribute
   */
  protected $mCssClass;
  /* value of the title attribute
   */
  protected $mTitle;
  /* text assigned to the value attribute
   */
  protected $mValue;
  /* value of the onclick attribute
   */
  protected $mOnClick;
  /*  Default constructor. The parameters include value of the type attribute of the element,
    value of the id attribute, value of the name attribute, value of the class attribute,
    value of the title attribute, value of the onclick attribute and
    text on the caption to be inserted before the element.
   */
  public function __construct($aId, $aName, $aCssClass, $aTitle, $aValue, $aOnClick)
  {
    $this->setId($aId);
    $this->setName($aName);
    $this->setCssClass($aCssClass);
    $this->setTitle($aTitle);
    $this->setValue($aValue);
    $this->setOnClick($aOnClick);
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
  /* sets the text for the value attribute
   */
  public function setValue($aValue)
  {
    $this->mValue = $aValue;
  }
  /* Sets the value of the onclick attribute.
   */
  public function setOnClick($aValue)
  {
    $this->mOnClick = $aValue;
  }
  /* Returns HTML for the element.
   */
  public function generateHtml()
  {
    return sprintf("<button type='button' name='%s' id='%s' onclick='%s' class='%s' title='%s'>%s</button>", 
            $this->mName, $this->mId, $this->mOnClick, $this->mCssClass, $this->mTitle, $this->mValue
    );
  }
}
?>
