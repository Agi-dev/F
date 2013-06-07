<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Image\Adapter\Native is
 * the native adapter for the image service,
 * that implements PHP natives primitives.
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
 * @see F/Technical/Image/Adapter/Definition.php
 */
require_once 'F/Technical/Image/Adapter/Definition.php';

/**
 * @see F/Technical/Filesystem/Service.php
 */
require_once 'F/Technical/Filesystem/Service.php';

/**
 * F\Technical\Image\Adapter\Native is the native adapter
 * for the image service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Image\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::checkFileExists()
	 */
	public function checkFileExists ($filename)
	{
		\F\Technical\Filesystem\Service::singleton()->checkFileExists($filename);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Image\Adapter\Definition::isJpeg()
	 */
	public function isJpeg($filename)
	{
		$info = getimagesize($filename);
		return (IMAGETYPE_JPEG === $info[2]);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Image\Adapter\Definition::getSize()
	 */
	public function getSize($filename)
	{
		return \F\Technical\Filesystem\Service::singleton()->getFileSize($filename);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Image\Adapter\Definition::getDimension()
	 */
	public function getDimension($filename)
	{
		$err1   = error_get_last();
        $result = @getimagesize($filename);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return $result;	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Image\Adapter\Definition::resize()
	 */
	public function resize($filename, $newWidth, $newHeight, $curWidth, $curHeight)
	{
		$err1   = error_get_last();
		$src = @imagecreatefromjpeg($filename);
		$new = @imagecreatetruecolor($newWidth, $newHeight);
		$result = @imagecopyresampled($new, $src, 0, 0, 0, 0, $newWidth, $newHeight, $curWidth, $curHeight);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $new;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Image\Adapter\Definition::deleteFile()
	 */
	public function deleteFile($filename)
	{
		\F\Technical\Filesystem\Service::singleton()->deleteFile($filename);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Image\Adapter\Definition::saveJpeg()
	 */
	public function saveJpeg($resource, $filename)
	{
		$err1   = error_get_last();
		$result = @imagejpeg($resource, $filename, 95);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $this;
	}
}
// @codeCoverageIgnoreEnd