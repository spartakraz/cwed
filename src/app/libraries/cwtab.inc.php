<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwtab.inc.php
  Subpackage:   library
  Summary:      a tab used for selecting a page on the tabbed page control
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/*  Represents a tab for selecting a page on the tabbed page control. Built around
  the radio input element.
 */
class CWLIB_Tab extends CWLIB_HtmlObject
{
  /*  Value of the checked attribute. Can be assigned either "checked" or
    an empty string.
   */
  protected $mChecked;
  /* Value of the title attribute.
   */
  protected $mTitle;
  /*  Text of the label attached to the tab.
   */
  protected $mCaption;
  /*  Default constructor. Params include value of the id attribute,
    value of the name attribute, value of the checked attribute,
    value of the title attribute and text of the label attached to the tab.
   */
  public function __construct($id, $aName, $aChecked, $aTitle, $aCaption)
  {
    $this->setId($id);
    $this->setName($aName);
    $this->setChecked($aChecked);
    $this->setTitle($aTitle);
    $this->setCaption($aCaption);
  }
  /* Sets value of the checked attribute.
   */
  public function setChecked($aValue)
  {
    $this->mChecked = $aValue;
  }
  /* Sets value of the title attribute.
   */
  public function setTitle($aValue)
  {
    $this->mTitle = $aValue;
  }
  /* Sets text of the label attached to the tab.
   */
  public function setCaption($aValue)
  {
    $this->mCaption = $aValue;
  }
  /* Returns HTML for the tab.
   */
  public function generateHtml()
  {
    return
            "
<input type='radio' id='{$this->mId}' name='{$this->mName}' {$this->mChecked}>
<label for='{$this->mId}' title='{$this->mTitle}'>
{$this->mCaption}
</label>
            ";
  }
}
?>
