<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Trace\Adapter\Native is
 * the native adapter for the trace service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Trace\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Trace\Adapter;

/**
 * @see F/Technical/Trace/Adapter/Definition.php
 */
require_once 'F/Technical/Trace/Adapter/Definition.php';

/**
 * F\Technical\Trace\Adapter\Native is the native adapter
 * for the trace service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Trace\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * level for key
     * @var array
     */
    private $_levels;
    
    /**
     * log is enable ?
     * @var bool
     */
    private $_enable = false;
    
    /**
     * log filename
     * @var string
     */
    private $_logfile;
    
    /**
     * log resource
     * 
     * @var resource
     */
    private $_logResource;

    /**
     * Constructs a new adapter.
     *
     * @return F\Technical\Trace\Adapter\Native
     */
    public function __construct()
    {
        $this->_levels = array();
        $this->_enable = false;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::setLevelForKeys()
     */
    public function setLevelForKeys($levels)
    {
        $this->_levels = array_merge($this->_levels, $levels);
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::getLevelForKey()
     */
    public function getLevelForKey($key)
    {
        if ( true === array_key_exists($key, $this->_levels)) {
            return $this->_levels[$key];
        }
        return null;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::getDatetime()
     */
    public function getDatetime()
    {
        return date('Y/m/d H:i');
    }
    
    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::log()
     */
    public function log($msg)
    {
    	return \F\Technical\File\Service::singleton()->writeResource($this->_logResource, $msg);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::checkFileExists()
     */
    public function checkFileExists($filename)
    {
        return \F\Technical\File\Service::singleton()->checkFileExists($filename);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::parseIniFile()
     */
    public function parseIniFile($filename)
    {
        return \F\Technical\File\Service::singleton()->parseIniFile($filename);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::getMsg()
     */
    public function getMsg($key, $params=null)
    {
        return  \F\Technical\I18n\Service::singleton()->translate($key, $params);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::setTraceEnabled()
     */
    public function setTraceEnabled($state)
    {
    	$this->_enable = true === $state;
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::isTraceEnabled()
     */
    public function isTraceEnabled()
    {
    	return $this->_enable; 
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::setFile()
     */
    public function setFile($filename)
    {
    	$this->_logfile = $filename;
    	return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::openLog()
     */
    public function openLog()
    {
    	if ( null === $this->_logResource ) {
    		$this->_logResource = \F\Technical\File\Service::singleton()
    								->appendFile($this->_logfile);
    	}
    	return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see F\Technical\Trace\Adapter.Definition::closeLog()
     */
    public function closeLog()
    {
    	if ( null !== $this->_logResource ) {
    		\F\Technical\File\Service::singleton()
    			->closeResource($this->_logResource);
    		$this->_logResource = null;
    	}
    	return $this;
    }
}
// @codeCoverageIgnoreEnd