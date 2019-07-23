<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwtextarea.inc.php
  Subpackage:   library
  Summary:      encapsulation of the <textarea> form element
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Represents the <textarea> form element.
 */
class CWLIB_TextArea extends CWLIB_HtmlObject
{
  /* Value of the class attribute.
   */
  protected $mCssClass;
  /* Value of the title attribute.
   */
  protected $mTitle;
  /* Value of the readonly attribute. Can be assigned
   */
  protected $mReadOnly;
  /* contents of the element
   */
  protected $mValue;
  /*  Default constructor. Parameters includes value of the id attribute,
    value of the name attribute, value of the class attribute,
    value of the title attribute, value of the readonly attribute and
    contents of the element.
   */
  public function __construct($id, $aName, $aCssClass, $aTitle, $aReadOnly, $aValue)
  {
    $this->setId($id);
    $this->setName($aName);
    $this->setCssClass($aCssClass);
    $this->setTitle($aTitle);
    $this->setReadOnly($aReadOnly);
    $this->setValue($aValue);
  }
  /* Sets the value of class attribute.
   */
  public function setCssClass($aValue)
  {
    $this->mCssClass = $aValue;
  }
  /* Sets the value of the title attribute
   */
  public function setTitle($aValue)
  {
    $this->mTitle = $aValue;
  }
  /* Sets the value of the readonly attribute.
   */
  public function setReadOnly($aValue)
  {
    $this->mReadOnly = $aValue;
  }
  /* Sets the element's contents.
   */
  public function setValue($aValue)
  {
    $this->mValue = $aValue;
  }
  /* Returns HTML for the element.
   */
  public function generateHtml()
  {
    return sprintf("<textarea name='%s' id='%s'  title='%s' class='%s' %s onselect='CW_jsform.symbolSearch()'>", $this->mName, $this->mId, $this->mTitle, $this->mCssClass, $this->mReadOnly ? " readonly" : ""
            ) . $this->mValue . "</textarea>";
  }
}
?>
