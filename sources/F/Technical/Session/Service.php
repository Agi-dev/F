<?php
/**
 * F\Technical\Session\Service is a class to handle session operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package   F\Technical\Session
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Session;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Session\Service is a class to handle session operations.
 *
 * @category F
 * @package F\Technical\Session
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
	 * @return \F\Technical\Session\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Technical\Session\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Technical\Session\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
	
	/**
	 * Récupère une valeur en session
	 * 
	 * @param string $varname
	 * 
	 * @return mixed
	 */
	public function get($varname)
	{
		$this->checkVarnameExists($varname);
		return $this->getAdapter()->get($varname);
	}
	
	/**
	 * Sauvegarde en session une variable
	 * 
	 * @param string $varname
	 * @param mixed  $value
	 * 
	 * @return \F\Technical\Session\Service
	 */
	public function set($varname, $value)
	{
		$this->getAdapter()->set($varname, $value);
		return $this;
	}
	
	/**
	 * check var exists in session
	 * 
	 * @param string $varname
	 * 
	 * @return \F\Technical\Session\Service
	 * @throw RuntimeException session.name.notfound
	 */
	public function checkVarnameExists($varname)
	{
		if (  false === $this->isVarnameExists($varname) ) {
			$this->throwException('session.name.notfound', $varname);
		}
		return $this;
	}
	
	/**
	 * Vérifie si une variable existe en session
	 * 
	 * @param string $varname
	 * 
	 * @return bool
	 */
	public function isVarnameExists($varname)
	{
		return $this->getAdapter()->isVarnameExists($varname);
	}
}