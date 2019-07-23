<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwmenuitem.inc.php
  Subpackage:   library
  Summary:      Represents a single item of drop-down box served to store menu items
  associated with a menu element
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* A single item of a drop down box with menu items. Built around the <a href> tag.
 */
class CWLIB_MenuItem
{
  /* Value of the href attribute.
   */
  protected $mHref;
  /* Value of the onclick attribute.
   */
  private $mOnClick;
  /* Value of the title attribute.
   */
  private $mTitle;
  /* caption of the item
   */
  private $mCaption;
  /*  Default constructor. Params include value of the href attribute,
    value of the onclick attribute, value of the title attribute,
    and caption of the item.
   */
  public function __construct($aHref, $aOnclick, $aTitle, $aCaption)
  {
    $this->setHRef($aHref);
    $this->setOnClick($aOnclick);
    $this->setTitle($aTitle);
    $this->setCaption($aCaption);
  }
  /* Sets the value of the href attribute
   */
  public function setHRef($aValue)
  {
    $this->mHref = $aValue;
  }
  /* Sets the value of the onclick attribute
   */
  public function setOnClick($aValue)
  {
    $this->mOnClick = $aValue;
  }
  /* Sets value of the title attribute
   */
  public function setTitle($aValue)
  {
    $this->mTitle = $aValue;
  }
  /* Sets caption of the item
   */
  public function setCaption($aValue)
  {
    $this->mCaption = $aValue;
  }
  /* Returns HTML for the item.
   */
  public function generateHtml()
  {
    return "<a href=\"{$this->mHref}\" onclick=\"{$this->mOnClick}\" title='{$this->mTitle}'>{$this->mCaption}</a>";
  }
}
/* Helper method for creating and then returning an instance of the CW_MenuItem class.
 */
function &CWLIB_menuItemFactory($aHref, $aOnclick, $aTitle, $aCaption)
{
  $obj = new CWLIB_MenuItem($aHref, $aOnclick, $aTitle, $aCaption);
  return $obj;
}
?>
