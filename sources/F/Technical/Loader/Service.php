<?php
/**
 * F\Technical\Loader\Service is a class to handle loader operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Loader
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Loader;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Loader\Service is a class to handle loader operations.
 *
 * @category F
 * @package F\Technical\Loader
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
	 * @return F\Technical\Loader\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Loader\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Loader\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
	
	/**
	 * Autoload projects class according to namespaces
	 * 
	 * namespaces is an array : array ( 'namespace1' => 'directory'),
	 * ex :  array("F" => "sources/F")
	 * 
	 * @param array $namespace
	 * 
	 * @return  \F\Technical\Base\Service
	 */
	public function autoload($namespace)
	{
		$this->getAdapter()->registerNamespaces($namespace)
						   ->autoload();
		return $this;
	}
}