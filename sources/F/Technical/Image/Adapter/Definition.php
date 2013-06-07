<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Image\Adapter\Definition
 * is the adapter interface for the image service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package    F\Technical\Image\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Image\Adapter;

/**
 * F\Technical\Image\Adapter\Definition
 * is the adapter interface for the image service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Image\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	
	/**
	 * Vérifie que le fichier existe
	 *
	 * @param string $filename
	 *
	 * @throw RuntimeException if not exists
	 * @return F\Technical\Excel\Adapter\Definition
	 */
	public function checkFileExists($filename);
	
	/**
	 * Vérifie si l'image est un jpeg
	 *
	 * @param string $filename
	 *
	 * @return bool
	 */
	public function isJpeg($filename);
	
	/**
	 * Récupère la taille de l'image en ko
	 *
	 * @param string $filename
	 *
	 * @return int
	 */
	public function getSize($filename);
	
	/**
	 * Get the size of an image
	 * 
	 * @param string $filename
	 * 
	 * @return array Index 0 and 1 contains respectively the width and the height of the image
	 */
	public function getDimension($filename);
	
	
	/**
	 * Copy and resize part of an image with resampling
	 * 
	 * @param string $filename
	 * @param int $newWidth
	 * @param int $newHeight
	 * @param int $curWidth
	 * @param int $curHeight
	 * 
	 * @return resource
	 */
	public function resize($filename, $newWidth, $newHeight, $curWidth, $curHeight);
	
	/**
	 * delete a file
	 * 
	 * @param string $filename
	 * 
	 */
	public function deleteFile($filename);
	
	/**
	 * save image to file
	 * @param unknown $resource
	 * @param unknown $filename
	 */
	public function saveJpeg($resource, $filename);
}
// @codeCoverageIgnoreEnd