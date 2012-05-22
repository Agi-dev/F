<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Filesystem\Adapter\Native is
 * the native adapter for the file service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François <francoisschneider@neuf.fr>
 * @package    F\Technical\Filesystem\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Filesystem\Adapter;

/**
 * @see F/Technical/Filesystem/Adapter/Definition.php
 */
require_once 'F/Technical/Filesystem/Adapter/Definition.php';

/**
 * F\Technical\Filesystem\Adapter\Native is the native adapter
 * for the file service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Filesystem\Adapter
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
	 * @see sources/F/Technical/Filesystem/Adapter/F\Technical\Filesystem\Adapter.Definition::isFileExists()
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
	 * @see sources/F/Technical/Filesystem/Adapter/F\Technical\Filesystem\Adapter.Definition::parseIniFile()
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

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Filesystem\Adapter.Definition::fopen()
	 */
	public function fopen($filename, $mode = 'r')
	{
		$err1   = error_get_last();
		$result = @fopen($filename, $mode);
		$err    = error_get_last();

		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}

		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Filesystem\Adapter.Definition::is_resource()
	 */
	public function is_resource($resource)
	{
		$err1   = error_get_last();
        $result = @is_resource($resource);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return true === $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Filesystem\Adapter.Definition::fwrite()
	 */
	public function fwrite($resource, $content)
	{
		$err1   = error_get_last();
        $result = @fwrite($resource, $content);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Filesystem\Adapter.Definition::fclose()
	 */
	public function fclose ($resource)
	{
		$err1   = error_get_last();
        $result = @fclose($resource);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return true === $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Filesystem\Adapter.Definition::getFileContents()
	 */
	public function getFileContents($filename)
	{
		$err1   = error_get_last();
        $result = @file_get_contents($filename);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return $result;
	}
}
// @codeCoverageIgnoreEnd