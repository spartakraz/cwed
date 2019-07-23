<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwmenu.inc.php
  Subpackage:   library
  Summary:      Represents a menu element to which a drop down box with menu items
  will be attached.
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/*  A menu element to which a drop down box with menu items
  will be attached.
 */
class CWLIB_Menu extends CWLIB_HtmlContainer
{
  /* array of menu items to appear in the menu's drop down content
   */
  private $mItems;
  /* default constructor
   */
  public function __construct()
  {
    $this->mItems = array();
  }
  /* adds a menu item to the menu's drop down content
   */
  public function addItem(&$aItem)
  {
    $this->mItems[] = $aItem;
  }
  /* Outputs HTML for the whole menu element with its menu items
   */
  public function generateHtml()
  {
    foreach ($this->mItems as &$item) {
      $this->printEmbeddedObject($item);
    }
  }
}
?>
