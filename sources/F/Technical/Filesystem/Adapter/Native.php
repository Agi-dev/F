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
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::getFileSize()
	 */
	public function getFileSize($filename)
	{
		$err1   = error_get_last();
        $result = @filesize($filename);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return (int) round($result / 1024);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::copy()
	 */
	public function copy($source, $destination)
	{
		$err1   = error_get_last();
		$result = @copy($source, $destination);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::mkdir()
	 */
	public function mkdir($dir) 
	{
		$err1   = error_get_last();
		$result = @mkdir($dir);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::scandir()
	 */
	public function scandir ($dir)
	{
		$err1   = error_get_last();
		$result = @scandir($dir);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::is_dir()
	 */
	public function is_dir ($filename)
	{
		$err1   = error_get_last();
		$result = @is_dir($filename);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return true === $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::unlink()
	 */
	public function unlink ($filename)
	{
		$err1   = error_get_last();
		$result = @unlink($filename);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::rmdir()
	 */
	public function rmdir ($dirname)
	{
		$err1   = error_get_last();
		$result = @rmdir($dirname);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Filesystem\Adapter\Definition::is_deleteable()
	 */
	public function is_deletable($filename)
	{
		return $this->is_writable($filename);
	}
	
	/**
	 * 
	 * @param unknown $filename
	 * @throws \RuntimeException
	 * @return boolean
	 */
	public function is_writable($filename)
	{
		$err1   = error_get_last();
		$result = @is_writable($filename);
		$err    = error_get_last();
		
		if (false === $result && (serialize($err1) !== serialize($err))) {
			throw new \RuntimeException($err['message'], 1000 + $err['type']);
		}
		
		return true === $result;
	}
}
// @codeCoverageIgnoreEnd