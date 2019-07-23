<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwpage.inc.php
  Subpackage:   library
  Summary:      Encapsulates a single page of the tabbed page control
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Represents a page of the tabbed page control.
 */
class CWLIB_Page
{
  /* Value of the ID attribute of the page's tab.
   */
  private $mRadioId;
  /* Value of the name attribute of the page's tab.
   */
  private $mRadioName;
  /* Value of the checked attribute of the page's tab.
   */
  private $mRadioChecked;
  /* Value of the title attribute of the page's tab.
   */
  private $mLabelTitle;
  /* Text of the label attached to the page's tab.
   */
  private $mLabelCaption;
  /*  Value of the title attribute of the page's content area represented by
    <div>.
   */
  private $mContentsTitle;
  /* Default constructor.
   */
  public function __construct()
  {
    
  }
  /* Sets value of the ID attribute of the page's tab.
   */
  public function setRadioId($aValue)
  {
    $this->mRadioId = $aValue;
  }
  /* Sets value of the name attribute of the page's tab.
   */
  public function setRadioName($aValue)
  {
    $this->mRadioName = $aValue;
  }
  /* Sets value of the checked attribute of the page's tab.
   */
  public function setRadioChecked($aValue)
  {
    $this->mRadioChecked = $aValue;
  }
  /* Sets value of the title attribute of the page's tab.
   */
  public function setLabelTitle($aValue)
  {
    $this->mLabelTitle = $aValue;
  }
  /* Text of the label attached to the page's tab.
   */
  public function setLabelCaption($aValue)
  {
    $this->mLabelCaption = $aValue;
  }
  /* Sets value of the title attribute of the page's content area
   */
  public function setContentsTitle($aValue)
  {
    $this->mContentsTitle = $aValue;
  }
  /* Returns starting HTML code for the page.
   */
  public function generateStartHtml()
  {
    $checked = $this->mRadioChecked ? " checked" : " ";
    $radioElem = new CWLIB_Tab($this->mRadioId, $this->mRadioName, $checked, $this->mLabelTitle, $this->mLabelCaption);
    $radioCode = $radioElem->generateHtml();
    return
            "
<div class='divtab'>
{$radioCode}
<div class='divtabcontents' title='{$this->mContentsTitle}'>
            ";
  }
  /* Returns ending HTML code for the page.
   */
  public function generateEndHtml()
  {
    return
            "
</div>
</div>
            ";
  }
}
/* Helper class for creating and returning an instance of CWLIB_Page.
 */
function &CWLIB_pageFactory($aRadioId, $aRadioName, $aRadioChecked, $aLabelTitle, $aLabelCaption, $aContentsTitle)
{
  $obj = new CWLIB_Page();
  $obj->setRadioId($aRadioId);
  $obj->setRadioName($aRadioName);
  $obj->setRadioChecked($aRadioChecked);
  $obj->setLabelTitle($aLabelTitle);
  $obj->setLabelCaption($aLabelCaption);
  $obj->setContentsTitle($aContentsTitle);
  return $obj;
}
?>
