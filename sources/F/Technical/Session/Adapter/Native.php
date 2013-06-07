<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Session\Adapter\Native is
 * the native adapter for the session service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package    F\Technical\Session\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Session\Adapter;

/**
 * @see F/Technical/Session/Adapter/Definition.php
 */
require_once 'F/Technical/Session/Adapter/Definition.php';

/**
 * @see Zend/Session/Namespace.php
 */
require_once 'Zend/Session/Namespace.php';
/**
 * F\Technical\Session\Adapter\Native is the native adapter
 * for the session service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Session\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * session 
	 * @var \Zend_Session_Namespace
	 */
	protected $_session;
	
	/**
	 * constructeur
	 */
	public function __construct()
	{
		$this->_session =  new \Zend_Session_Namespace('f_session');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Session\Adapter\Definition::isVarnameExists()
	 */
	public function isVarnameExists($varname)
	{
		return isset($this->_session->$varname);	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Session\Adapter\Definition::get()
	 */
	public function get($varname)
	{
		return $this->_session->$varname;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Session\Adapter\Definition::set()
	 */
	public function set($varname, $value)
	{
		$this->_session->$varname = $value;
		return $this;
	}
}
// @codeCoverageIgnoreEnd