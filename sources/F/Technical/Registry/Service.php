<?php
/**
 * F\Technical\Registry\Service is a class to handle registry operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Registry
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Registry;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Registry\Service is a class to handle registry operations.
 *
 * @category F
 * @package F\Technical\Registry
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
	 * @return F\Technical\Registry\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Registry\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Registry\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

    /**
     * Returns the property key.
     *
     * @param string $key the key
     *
     * @return mixed
     *
     * @throws Exception if an error occured
     */
    public function getProperty($key)
    {
        if ( false === $this->hasProperty($key)) {
            $this->throwException('config.key.unknown', $key);
        }

        $result = $this->getAdapter()->getProperty($key);
        return $result;
    }

    /**
     * Sets the value for the specified property in configuration.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return W_Technical_Config_Service
     *
     * @throws Exception if an error occured
     */
    public function setProperty($key, $value)
    {
        $this->getAdapter()->setProperty($key, $value);
        return $this;
    }

     /**
     * Tests if specified property exist and has value
     *
     * @param string $key the property name
     *
     * @return bool true if exists (and has a value different from null)
     */
    public function hasProperty($key)
    {
    	return $this->getAdapter()->hasProperty($key);
    }
}