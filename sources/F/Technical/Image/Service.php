<?php
/**
 * F\Technical\Image\Service is a class to handle image operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package   F\Technical\Image
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Image;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Image\Service is a class to handle image operations.
 *
 * @category F
 * @package F\Technical\Image
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
	/**
	 * Returns the singleton of this service
	 *
	 * @return \F\Technical\Image\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Technical\Image\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Technical\Image\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
	
	/**
	 * Vérifie si l'image est un jpeg
	 * 
	 * @param string $filename
	 * 
	 * @return bool
	 */
	public function isJpeg($filename)
	{
		$this->getAdapter()->checkFileExists($filename);
		return $this->getAdapter()->isJpeg($filename);
	}
	
	/**
	 * Récupère la taille de l'image en ko
	 * 
	 * @param string $filename
	 * 
	 * @return int
	 */
	public function getSize($filename)
	{
		$this->getAdapter()->checkFileExists($filename);
		return $this->getAdapter()->getSize($filename);
	}
	
	/**
	 * Récupère les dimensions d'une image
	 * 
	 * @param unknown $filename
	 * 
	 * @return array index 0 et 1 contiennent respectivement la largeur et la hauteur de l'image
	 */
	public function getDimension($filename)
	{
		return $this->getAdapter()->getDimension($filename);
	}
	
	/**
	 * Redimensionne une image de façon homothétique en fonction d'une hauteur
	 * 
	 * @param unknown $filename
	 * @param unknown $newHeight
	 * 
	 * @return \F\Technical\Image\Service
	 */
	public function resizeByHeight($filename, $newHeight)
	{
		$this->getAdapter()->checkFileExists($filename);
		
		// Calcul des nouvelles dimensions
		list($width, $height) = $this->getAdapter()->getDimension($filename);
		$newWidth = ($width / $height) * $newHeight;
		
		// redimension de façon homothétique sur la hauteur l'image
		$new = $this->getAdapter()->resize($filename, $newWidth, $newHeight, $width, $height);
		$this->getAdapter()->deleteFile($filename);
		$this->getAdapter()->saveJpeg($new, $filename);
		
		return $this;
	}
}