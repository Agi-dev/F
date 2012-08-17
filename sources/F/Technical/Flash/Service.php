<?php
/**
 * F\Technical\Flash\Service is a class to handle flash operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Flash
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Flash;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Flash\Service is a class to handle flash operations.
 *
 * @category F
 * @package F\Technical\Flash
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
	/**
	 * priority list
	 *
	 * @var array
	 */
	protected $_priority = array('success', 'notice', 'error', 'warning');

	/**
	 * Returns the singleton of this service
	 *
	 * @return \F\Technical\Flash\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Technical\Flash\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Technical\Flash\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

	/**
	 * save flash message with priority
	 *
	 * @param string $message
	 * @param string $priority
	 *
	 * @return \F\Technical\Flash\Service
	 */
	public function flash($message, $priority)
	{
	   	if ( false === in_array($priority, $this->_priority) ) {
	   		return $this->throwException('flash.priority.notfound', $priority);
	   	}

	   	$this->getAdapter()->addFlash($message, $priority);
	   	return $this;
	}

	/**
	 * Récupère la liste des messages flash
	 *
	 * @return array
	 */
	public function listFlash()
	{
		$list = $this->getAdapter()->listFlash();
		$this->getAdapter()->clearFlash();
		return $list;
	}
}