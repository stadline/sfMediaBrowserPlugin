<?php

/**
 * @package     sfMediaBrowser
 * @author      Vincent Agnano <vincent.agnano@particul.es>
 */
class BasesfMediaBrowserComponents extends sfComponents
{
    public function executeIcon(sfWebRequest $request)
    {
        $type = sfMediaBrowserUtils::getTypeFromExtension(sfMediaBrowserUtils::getExtensionFromFile($this->file_url));
        $class = ($type == 'image') ? 'sfMediaBrowserImageObject' : 'sfMediaBrowserFileObject';

        $this->file = new $class($this->file_url);
    }
}
