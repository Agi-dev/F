<?php
/**
 * F\Technical\Trace\Service is a class to handle trace operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Trace
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Trace;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Trace\Service is a class to handle trace operations.
 *
 * @category F
 * @package F\Technical\Trace
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
	 * @return F\Technical\Trace\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Trace\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Trace\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

    /**
     * Loads the levels from the specified file.
     *
     * @param string $path the path
     *
     * @return W_Technical_Trace_Service
     *
     * @throws Exception if an error occured
     */
    public function loadLevelsFromFile($path)
    {
        $this->getAdapter()->checkFileExists($path);
        $levels = $this->getAdapter()->parseIniFile($path);
        $this->setLevelForKeys($levels);

        return $this;
    }

    /**
     * Sets the level for the specified keys.
     *
     * @param array $levels the levels
     *
     * @return P\Technical\Trace\Service
     *
     * @throws Exception if an error occured
     */
    public function setLevelForKeys($levels)
    {
        if (false === is_array($levels)) {
            return $this;
        }

        $this->getAdapter()->setLevelForKeys($levels);

        return $this;
    }

    /**
     * Trace
     *
     * @param string $key
     * @param array $params
     */
    public function trace($key, $params = null )
    {
        if ( false === $this->getAdapter()->isTraceEnabled() ) {
        	return $this;
        }
        
        $level = $this->getLevelForKey($key);
        
        if ( false === $this->getAdapter()->isLevelEnabled() ) {
        	return $this;
        }
        
        if (null !== $params && false === is_array($params) ) {
        	$params = array($params);
        }
        
        $msg = '[' . $this->getAdapter()->getDatetime() . ']['
                . strtoupper($level) . '] '
                . $this->getMsg($key, $params) . "\n";

        $this->getAdapter()->write($key, $msg);
        
        return $this;
    }

    /**
     * get level for key
     *
     * @param unknown_type $key
     *
     * @return string (level or key if no level set for key)
     */
    public function getLevelForKey($key)
    {
        $level = $this->getAdapter()->getLevelForKey($key);
        if ( true === isset($level) ) {
            return $level;
        }
        return $key;
    }

    /**
     * get Message
     *
     * @param string $key
     * @param array $params
     *
     * @return string
     *
     * @throw RuntimeException
     */
    public function getMsg($key, $params = array())
    {
        return $this->getAdapter()->getMsg($key, $params);
    }

    /**
     * set if trace  is enable or not
     *
     * @param bool $state
     *
     * @return \F\Technical\Trace\Service
     */
    public function setTraceEnabled($state)
    {
        $this->getAdapter()->setTraceEnabled(true === $state);

        return $this;
    }

    /**
     * get if trace is enable or not
     *
     * @return bool
     */
    public function isTraceEnabled()
    {
        return $this->getAdapter()->isTraceEnabled();
    }

    /**
     * configure trace
     *
     *    config['file']            string: filename for trace (required)
     *          ['keylevelfile']    string: keylevel filename
     *          ['activated']       int: 1|0 trace activated or not (not by default)
     *          ['filters'][levels] array::string: levels to filter
     *
     * @param array $config
     *
     * @return \F\Technical\Trace\Service
     */
    public function configure($config)
    {
    	// init with W levels
        $this->loadLevelsFromFile(dirname(__FILE__) . '/../resources/trace/default.ini');
        $this->loadLevelsFromFile($config['keylevelfile']);
        $this->getAdapter()->setTraceEnabled($config['activated']);
    	$this->getAdapter()->setFile($config['file']);


    	return $this;
    }
}