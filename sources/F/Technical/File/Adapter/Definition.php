<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\File\Adapter\Definition
 * is the adapter interface for the file service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois <francoisschneider@neuf.fr>
 * @package    F\Technical\File\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\File\Adapter;

/**
 * F\Technical\File\Adapter\Definition
 * is the adapter interface for the file service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\File\Adapter
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
}
// @codeCoverageIgnoreEnd