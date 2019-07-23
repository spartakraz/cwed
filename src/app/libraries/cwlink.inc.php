<?php
/*
  Application:  CWED (http://ccwed.ourproject.org/)
  File:         cwlink.inc.php
  Subpackage:   library
  Summary:      encapsulation of the <link> tag
  Version:      0.8.5
  Copyright (C) 2017-2018, the CWED devel team
 */
/* Represents the <input> HTML form element.
 */
class CWLIB_LinkRel extends CWLIB_HtmlObject
{
  /* value of the rel attribute of the tag
   */
  protected $mRel;

  /* value of the href attribute
   */
  protected $mHref;

  /* value of the type attribute
   */
  protected $mType;
  /*  Default constructor. The parameters include values of the rel and href attributes
    of the element.
   */
  public function __construct($id, $aName, $aRel, $aHref, $aType)
  {
    $this->setId($id);
    $this->setName($aName);
    $this->setRel($aRel);
    $this->setHRef($aHref);
    $this->setType($aType);
  }
  /* Sets the value of the rel attribute.
   */
  public function setRel($aValue)
  {
    $this->mRel = $aValue;
  }
  /* Sets the value of the href attribute.
   */
  public function setHRef($aValue)
  {
    $this->mHref = $aValue;
  }
  /* Sets the value of the type attribute.
   */
  public function setType($aValue)
  {
    $this->mType = $aValue;
  }
  /* Returns HTML for the element.
   */
  public function generateHtml()
  {
    return !is_null($this->mType) ? sprintf("<link rel='%s' href='%s' type='%s'>", $this->mRel, $this->mHref, $this->mType) :
            sprintf("<link rel='%s' href='%s'>", $this->mRel, $this->mHref);
  }
}
?>
