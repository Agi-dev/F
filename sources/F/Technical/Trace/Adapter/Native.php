<?php
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
     * @var array
     */
    private $_levels;

    /**
     * Constructs a new adapter.
     *
     * @return P\Technical\Trace\Adapter\Native
     */
    public function __construct()
    {
        $this->_levels = array();
    }

    /**
     * Sets the specified list of levels.
     *
     * @param array $levels the levels
     *
     * @return P\Technical\Trace\Adapter\Native
     *
     * @throws Exception if an error occured
     */
    public function setLevelForKeys($levels)
    {
        $this->_levels = array_merge($this->_levels, $levels);
        return $this;
    }

    /**
     * Returns the current level for the specified key.
     *
     * @param string $key the key
     *
     * @return string
     *
     * @throws Exception if an error occured
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
     * @see sources/F/Technical/Trace/Adapter/F\Technical\Trace\Adapter.Definition::configure()
     */
    public function configure($appConfig)
    {
    	throw new \RuntimeException (
    		"Feature '" . __METHOD__ . "' not yet implemented"
    	);
    }

    /**
     * get date time
     *
     * @return string
     */
    public function getDatetime()
    {
        return date('Y/m/d H:i');
    }

    /**
     * Write trace message
     *
     * @param string $key
     * @param string $msg
     *
     * @return bool
     *
     * @throws RuntimeException
     */
    public function write($key, $msg)
    {
    	throw new \RuntimeException (
    		"Feature '" . __METHOD__ . "' not yet implemented"
    	);
    }

    /**
     * test if file exist
     *
     * @param string $filename
     *
     * @return bool
     */
    public function isFileExists($filename)
    {
        return file_exists($filename);
    }

    /**
     * parse ini file
     *
     * @param string $filename
     *
     * @return array
     */
    public function parseIniFile($filename)
    {
        return parse_ini_file($filename);
    }

    /**
     * Get message
     *
     * @param string $key
     *
     * @param array $params
     *
     * @return string
     */
    public function getMsg($key, $params=null)
    {
        return  \F\Technical\I18n\Service::singleton()->translate($key, $params);
    }
}