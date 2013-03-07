<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Filesystem\Adapter\Definition
 * is the adapter interface for the file service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois <francoisschneider@neuf.fr>
 * @package    F\Technical\Filesystem\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Filesystem\Adapter;

/**
 * F\Technical\Filesystem\Adapter\Definition
 * is the adapter interface for the file service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Filesystem\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
	 * is file exists return true
	 *
	 * @param string $filename
	 *
	 * @return bool
	 */
	public function isFileExists($filename);

	/**
	 * Parse un fichier Ini
	 *
	 * @param string $filename
	 *
	 * @return array
	 */
	public function parseIniFile($filename);

	/**
	 * open a file
	 *
	 * @param string $filename
	 * @param string $mode (r, a, a+, w, w+ ...)
	 *
	 * @return resource
	 */
	public function fopen($filename, $mode = 'r');

	/**
	 * check if is a resource
	 *
	 * @param resource $resource
	 *
	 * @return bool
	 */
	public function is_resource($resource);

	/**
	 *  Binary-safe file write
	 *
	 * @param resource $resource
	 * @param string $content
	 *
	 * @return returns the number of bytes written, or FALSE on error
	 */
	public function fwrite($resource, $content);

	/**
	 * Closes an open file pointer
	 *
	 * @param resource $resource file pointer
	 *
	 * @return bool
	 */
	public function fclose ($resource);

	/**
	 * Reads entire file into a string
	 *
	 * @param string $filename
	 *
	 * @return string
	 */
	public function getFileContents($filename);
	
	/**
	 * Give file size in ko
	 *
	 * @param $filename
	 *
	 * @return int
	 */
	public function getFileSize($filename);
	
	/**
	 * Copies file
	 *
	 * @param string $source
	 * @param string $destination
	 *
	 * @return Asm\Technical\Filesystem\Adapter\Definition
	 */
	public function copy($source, $destination);
	
	/**
	 * List files and directories inside the specified path
	 * 
	 * @param string $dir
	 * 
	 * @return array
	 */
	public function scandir($dir);
	
	/**
	 * Tells whether the filename is a directory
	 *
	 * @param string $filename
	 *
	 * @return boolean
	*/
	public function is_dir($filename);
	
	/**
	 * Makes directory
	 * 
	 * @param unknown $dir
	 */
	public function mkdir($dir);
	
	/**
	 * Deletes a file
	 *
	 * @param string $filename
	 *
	 * @return boolean
	 */
	public function unlink($filename);
	
	/**
	 * Removes directory
	 *
	 * @param string $filename
	 *
	 * @return boolean
	 */
	public function rmdir($dirname);
	
	/**
	 * Check if filename is deleteable
	 * 
	 * @param string $filename
	 * 
	 * @return bool
	 */
	public function is_deletable($filename);
}
// @codeCoverageIgnoreEnd