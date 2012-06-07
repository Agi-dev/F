<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Auth\Adapter\Native is
 * the native adapter for the auth service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Auth\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Auth\Adapter;

/**
 * @see F/Technical/Auth/Adapter/Definition.php
 */
require_once 'F/Technical/Auth/Adapter/Definition.php';

/**
 * F\Technical\Auth\Adapter\Native is the native adapter
 * for the auth service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Auth\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * Auth identity
	 * @var mixed
	 */
	protected $_identity = null;

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Auth\Adapter.Definition::getIdentity()
	 */
	public function getIdentity()
	{
		return $this->_identity;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Auth\Adapter.Definition::setIdentity()
	 */
	public function setIdentity($identity)
	{
		$this->_identity = $identity;
	}
}
// @codeCoverageIgnoreEnd