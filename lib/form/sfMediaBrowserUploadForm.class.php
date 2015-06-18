<?php

/**
 *
 *
 * @package     sfMediaBrowser
 * @subpackage  form
 * @author      Vincent Agnano <vincent.agnano@particul.es>
 */
class sfMediaBrowserUploadForm extends sfForm
{

  public function configure()
  {
    $this->setWidgets(array(
      'file'      => new sfWidgetFormInputFile(),
      'directory' => new sfWidgetFormInputHidden(),
    ));

    $this->widgetSchema->setNameFormat('upload[%s]');

    $this->setValidators(array(
      'file'      => new sfValidatorFile(array('path' => $this->getValue('directory'))),
      'directory' => new sfValidatorMediaBrowserDirectory(array(
                      'relative'  => true,
                      'root'      => sfConfig::get('sf_web_dir').'/'.sfMediaBrowserUtils::getRootDir(),
                      'root_allowed'  => true,
      )),
    ));
  }
}