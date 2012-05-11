<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Loader\Adapter\Native is
 * the native adapter for the loader service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Loader\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Loader\Adapter;

/**
 * @see F/Technical/Loader/Adapter/Definition.php
 */
require_once 'F/Technical/Loader/Adapter/Definition.php';

/**
 * F\Technical\Loader\Adapter\Native is the native adapter
 * for the loader service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Loader\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * loader class
	 * 
	 * @var Phalcon_Loader 
	 */
	protected $_loader;
	
	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$this->_loader = new \Phalcon_Loader();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Loader\Adapter.Definition::registerNamespaces()
	 */
	public function registerNamespaces($namespaces)
	{
		$this->_loader->registerNamespaces($namespaces);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Loader\Adapter.Definition::autoload()
	 */
	public function autoload()
	{
		$this->_loader->register();
		return $this;
	}
}
// @codeCoverageIgnoreEnd