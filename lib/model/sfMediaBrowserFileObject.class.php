<?php

/*
 * This file is part of the sfMediaBrowserPlugin package.
 * (c) Vincent Agnano <vincent.agnano@particul.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfMediaBrowserFileObject represents a file.
 *
 * @package    sfMediaBrowser
 * @subpackage model
 * @author     Vincent Agnano <vincent.agnano@particul.es>
 */
class sfMediaBrowserFileObject
{
  protected $file_url,
            $root_path,
            $name,
            $type,
            $size,
            $icon,
            $directory_separator
            ;

  /**
   *
   * @param string $file the absolute file path or relative (from under web_root)
   */
  public function __construct($file, $root_path = null)
  {
    $this->root_path = $root_path ? realpath($root_path) : realpath(sfConfig::get('sf_web_dir'));
    $this->directory_separator = DIRECTORY_SEPARATOR;

    // $file is absolute
    if($absolute = realpath($file))
    {
      $this->file_url = preg_replace('`^('.$this->root_path.')`', '', $absolute);
    }
    else
    {
      $this->file_url = $file;
    }

      $webDir = rtrim(sfConfig::get('app_sf_media_browser_web_dir'), '/') . '/';
      $this->file_url = $webDir . $this->cleanFileUrlFromRootPath();
  }
  

  public function __toString()
  {
    return $this->getName();
  }
  
  
  public function exists()
  {
    return file_exists($this->getPath());
  }
  

  public function getType()
  {
    return sfMediaBrowserUtils::getTypeFromExtension($this->getExtension());
  }

  
  /**
   *
   * @return boolean
   */
  public function isImage()
  {
    return false;
  }

  /**
   *
   * @return string icon file name
   */
  public function getIcon()
  {
    if(!$this->icon)
    {
      $this->icon = sfMediaBrowserUtils::getIconFromExtension($this->getExtension());
    }
    return $this->icon;
  }
  

  public function getExtension()
  {
    return pathinfo($this->getUrl(), PATHINFO_EXTENSION);
  }

    public function getFilePath()
    {
        return str_replace(
            sfConfig::get('app_sf_media_browser_web_dir'),
            '',
            $this->file_url
        );
    }

  public function getPath()
  {
    return realpath($this->getRootPath().'/'.$this->getFilePath());
  }
  
  
  public function getUrl()
  {
    return $this->file_url;
  }
  
  
  public function getUrlDir()
  {
    return pathinfo($this->getUrl(), PATHINFO_DIRNAME);
  }


  public function getRootPath()
  {
    return realpath($this->cleanFolder($this->root_path));
  }

  
  public function getName($with_extension = true)
  {
    if(!$this->name)
    {
      $this->name = pathinfo($this->file_url, PATHINFO_FILENAME);
    }
    return $with_extension && $this->getExtension()
			      ? $this->name.'.'.$this->getExtension()
			      : $this->name
			      ;
  }
  
  
  /**
   * Get a filesize
   * @param int $round A divider to round with
   * @return int The rounded value
   */
  public function getSize($round = 1000)
  {
    if(!$this->size)
    {
      $this->size = filesize($this->getPath());
    }
    return $round >= 1 ? round($this->size/$round) : $this->size;
  }


  protected function cleanFolder($folder)
  {
    $separator = $this->getDirectorySeparator();
    $cleaned = preg_replace('`'.$separator.'+`', $separator, $folder);
    //do not add a slash for windows
    $os = strtoupper($_SERVER['SERVER_SOFTWARE']);
    if(!preg_match('/WIN/',$os)) {
      $cleaned = $separator == '/' && substr($cleaned, 0, 1) != $separator ? $separator.$cleaned : $cleaned;
    }
    $cleaned = substr($cleaned, -1, 1) == $separator ? substr($cleaned, 0, -1) : $cleaned;
    return $cleaned;
  }
  
  
  public function getDirectorySeparator()
  {
    return $this->directory_separator;
  }
  
  
  public function setDirectorySeparator($separator)
  {
    $this->directory_separator = $separator;
  }
  
  
  public function delete()
  {
    if($this->exists())
    {
      return unlink($this->getPath());
    }
    return false;
  }

    /**
     * Remove root_path end from file start
     * $file = /uploads/crsmr-normandie-haute/cdsmr-seine-maritime/foyer-rural-de-isneauville/attestation-adhesion-2401220909.pdf"
     * $root_path = /home/assos/www/uploads/
     * We have to remove the "uploads" duplicate
     */
    private function cleanFileUrlFromRootPath()
    {
        $root_path_directories = explode($this->directory_separator, $this->root_path);
        $file_directories = explode($this->directory_separator, $this->file_url);

        $directoryIndex = 0;
        foreach ($root_path_directories as $root_path_directory) {
            if ($root_path_directory == $file_directories[$directoryIndex]) {
                unset($file_directories[$directoryIndex]);
                $directoryIndex++;
            }
        }

        return implode($this->directory_separator, $file_directories);
    }
}
