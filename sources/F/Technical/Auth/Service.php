<?php
/**
 * F\Technical\Auth\Service is a class to handle auth operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Auth
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Auth;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Auth\Service is a class to handle auth operations.
 *
 * @category F
 * @package F\Technical\Auth
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
	 * @return F\Technical\Auth\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Auth\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Auth\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

	/**
     * Returns true if and only if an identity is available from storage
     *
     * @return boolean
     */
	public function hasIdentity()
	{
		$ident = $this->getIdentity();
		return ( false === empty( $ident ) );
	}

	/**
     * Returns the identity or null if no identity is available
     *
     * @return mixed|null
     */
	public function getIdentity()
	{
		return $this->getAdapter()->getIdentity();
	}
}