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
 * @see F/Technical/Session/Service.php
 */
require_once 'F/Technical/Session/Service.php'; 

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
	/**
	 * liste des messages flash
	 * @var array
	 */
	protected $_flash = array();
	
	/**
	 * session 
	 * @var \F\Technical\Session\Service
	 */
	protected $_session;
	
	/**
	 * constructeur
	 */
	public function __construct()
	{
		$this->_session =  \F\Technical\Session\Service::singleton();
		if ( true === $this->_session->isVarnameExists('f_flashSession') ) {
			$this->_flash = $this->_session->get('f_flashSession');
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Flash\Adapter.Definition::addMessage()
	 */
	public function addFlash($msg, $priority)
	{
		$this->_flash[$msg] = $priority;
		return $this->_saveToSession();
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
    	return $this->_saveToSession();
    }
    
    /**
     * (non-PHPdoc)
     * @see \F\Technical\Flash\Adapter\Definition::isFlashExists()
     */
    public function isFlashExists()
    {
    	return (count($this->_flash) > 0);
    }
    
    /**
     * Sauvegarde en session
     * @return \F\Technical\Flash\Adapter\Native
     */
    protected function _saveToSession()
    {
    	$this->_session->set('f_flashSession' ,$this->_flash);
    	return $this;
    }
}
// @codeCoverageIgnoreEnd