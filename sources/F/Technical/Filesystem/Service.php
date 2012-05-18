<?php
/**
 * F\Technical\Filesystem\Service is a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois <francoisschneider@neuf.fr>
 * @package   F\Technical\Filesystem
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Filesystem;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Filesystem\Service is a class to handle file operations.
 *
 * @category F
 * @package F\Technical\Filesystem
 * @copyright Copyright (c) 2012 <COPYRIGHT>
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
	 * @return F\Technical\Filesystem\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Filesystem\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Filesystem\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

	/**
	 * Check if file exists throw exception if not
	 *
	 * @param string $filename
	 *
	 * @return \F\Technical\Filesystem\Service
	 *
	 * @throws RuntimeException
	 */
	public function checkFileExists($filename)
	{
		if ( false === $this->isFileExists($filename) ) {
			$this->throwException('filesystem.file.notfound', $filename);
		}
		return $this;
	}

	/**
	 * is file exists return true
	 *
	 * @param string $filename
	 *
	 * @return bool
	 */
	public function isFileExists($filename)
	{
		return $this->getAdapter()->isFileExists($filename);
	}

	/**
	 * Parse ini file
	 *
	 * @param string $filename
	 *
	 * @return array
	 *
	 * @thrown RuntimeException
	 */
	public function parseIniFile($filename)
	{
		$this->checkFileExists($filename);
		return $this->getAdapter()->parseIniFile($filename);
	}

	/**
	 * open file as resource
	 *
	 * @param string $filename
	 *
	 * @return resource
	 *
	 * @thrown \RuntimeException on error
	 */
	public function appendFile($filename)
	{
		return $this->getAdapter()->fopen($filename, 'a');
	}

	/**
	 * Writes the specified message to the specified opened resource.
	 *
	 * @param resource $resource
	 *
	 * @param string $content
	 *
	 * @return returns the number of bytes written, or FALSE on error
	 */
	public function writeResource($resource, $content)
	{
		$this->checkResource($resource);
		return $this->getAdapter()->fwrite($resource, $content);
	}

	/**
	 * check if resource is resource
	 *
	 * @param resource $resource
	 *
	 * @return \F\Technical\Filesystem\Service
	 */
	public function checkResource($resource)
	{
		if (false === $this->getAdapter()->is_resource($resource)) {
			$this->throwException('filesystem.resource.badformat');
		}

		return $this;
	}

	/**
	 * Close a file resource
	 *
	 * @param resource $resource
	 *
	 * @return \F\Technical\Filesystem\Service
	 */
	public function closeResource($resource)
	{
		if (true === $this->getAdapter()->is_resource($resource)) {
			return $this->getAdapter()->fclose($resource);
		}
		return true;
	}

    /**
     * check if dir exist
     *
     * @param $path
     *
     * @return \F\Technical\Filesystem\Service
     *
     * @throw RuntimeException filesystem.dir.notfound
     */
	public function checkDirExists($path)
    {
        if ( false === $this->isFileExists($path) ) {
            $this->throwException('filesystem.dir.notfound', $path);
        }
        return $this;
    }
}