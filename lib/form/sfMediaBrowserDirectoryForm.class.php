<?php

/**
 *
 *
 * @package     sfMediaBrowser
 * @subpackage  form
 * @author      Vincent Agnano <vincent.agnano@particul.es>
 */
class sfMediaBrowserDirectoryForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'      => new sfWidgetFormInput(),
      'directory' => new sfWidgetFormInputHidden(),
    ));

    $this->widgetSchema->setNameFormat('directory[%s]');
    
    $this->setValidators(array(
      'name'      => new sfValidatorString(array('trim' => true)),
      'directory' => new sfValidatorMediaBrowserDirectory(array(
              'relative'  => true,
              'root'      => sfMediaBrowserUtils::getRootDir(),
              'root_allowed' => true,
      )),
    ));
    
    $this->getValidatorSchema()->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'postValidator')))
    );
  }
  
  public function postValidator($validator, $values)
  {
    $values['name'] = sfMediaBrowserStringUtils::slugify($values['name']);
    return $values;
  }
}