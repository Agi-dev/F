<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Flash\Adapter\Native is
 * the native adapter for the flash service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Flash\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Flash\Adapter;

/**
 * @see F/Technical/Flash/Adapter/Definition.php
 */
require_once 'F/Technical/Flash/Adapter/Definition.php';

/**
 * F\Technical\Flash\Adapter\Native is the native adapter
 * for the flash service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Flash\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	protected $_flash = array();
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Flash\Adapter.Definition::addMessage()
	 */
	public function addFlash($msg, $priority)
	{
		array_push($this->_flash, array($msg => $priority));
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Flash\Adapter.Definition::listFlash()
	 */
	public function listFlash()
	{
		return $this->_flash;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Flash\Adapter.Definition::clearFlash()
	 */
    public function clearFlash()
    {
    	$this->_flash = array();
    	return $this;
    }
}
// @codeCoverageIgnoreEnd