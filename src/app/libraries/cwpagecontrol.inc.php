<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwpagecontrol.inc.php
  Subpackage:   library
  Summary:      Encapsulates a tabbed page control
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Represents a tabbed page control.
 */
class CWLIB_PageControl extends CWLIB_HtmlContainer
{
  // Array of pages contained within this tabbed page control.
  protected $mPages;
  // Array of textareas contained within this tabbed page control.
  protected $mTextAreas;
  /* outputs HTML code which starts declaration of given page
   */
  protected function initPage(&$aPage)
  {
    echo $aPage->generateStartHtml();
  }
  /* outputs HTML code which ends declaration of given page
   */
  protected function finalizePage(&$aPage)
  {
    echo $aPage->generateEndHtml();
  }
  /* Default constructor.
   */
  public function __construct()
  {
    $this->mPages = array();
    $this->mTextAreas = array();
  }
  /* Adds a page and a textarea to their respective arrays within this class.
   */
  public function addPage(&$aPage, &$aTextArea)
  {
    $this->mPages[] = $aPage;
    $this->mTextAreas[] = $aTextArea;
  }
  /* Outputs HTML code for the page control.
   */
  public function generateHtml()
  {
    $elemCount = count($this->mPages);
    for ($i = 0; $i < $elemCount; $i++) {
      $page = $this->mPages[$i];
      $this->initPage($page);
      $this->printEmbeddedObject($this->mTextAreas[$i]);
      $this->finalizePage($page);
    }
  }
}
?>
