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
        if ( false === $this->getAdapter()->isFileExists($path) ) {
            $this->throwException('file.notfound', $path);
        }
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
     * Configure Trace
     *
     * appConfig['file']         string: filename for trace (required)
     *          ['keylevelfile'] string: keylevel filename
     *          ['activated']    int: 1|0 trace activated or not (not by default)
     *          ['filters'][levels] array::string: levels to filter
     *                     [keys]   array::string: keys to filter
     *
     * @param array $appConfig
     *
     * @return W_Technical_Trace_Service
     *
     * @throw RuntimeException
     */
    public function configure($appConfig)
    {
        // init with W levels
        $this->loadLevelsFromFile(realpath(dirname(__FILE__) . '/../resources')
                                    . '/trace/default.ini');

        $file =  null;
        if ( true === isset($appConfig['keylevelfile']) ) {
            $this->loadLevelsFromFile($appConfig['keylevelfile']);
            unset($appConfig['keylevelfile']);
        }

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
        if (null !== $params && false === is_array($params) ) {
            $params = array($params);
        }

        $msg = '[' . $this->getAdapter()->getDatetime() . ']['
                . strtoupper($this->getLevelForKey($key)) . '] '
                . $this->getMsg($key, $params) . "\n";

        return $this->getAdapter()->write($key, $msg);
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
}