<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\File\Adapter\Native is
 * the native adapter for the file service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François <francoisschneider@neuf.fr>
 * @package    F\Technical\File\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\File\Adapter;

/**
 * @see F/Technical/File/Adapter/Definition.php
 */
require_once 'F/Technical/File/Adapter/Definition.php';

/**
 * F\Technical\File\Adapter\Native is the native adapter
 * for the file service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\File\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * (non-PHPdoc)
	 * @see sources/F/Technical/File/Adapter/F\Technical\File\Adapter.Definition::isFileExists()
	 */
	public function isFileExists($filename)
	{
		$err1   = error_get_last();
        $result = @file_exists($filename);
        $err    = error_get_last();
        
        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        } 
        
        return true === $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see sources/F/Technical/File/Adapter/F\Technical\File\Adapter.Definition::parseIniFile()
	 */
	public function parseIniFile($filename)
	{
		$err1   = error_get_last();
        $result = @parse_ini_file($filename);
        $err    = error_get_last();
        
        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        } 
        
        return $result;
	}
}
// @codeCoverageIgnoreEnd