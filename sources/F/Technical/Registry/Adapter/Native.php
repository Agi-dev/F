<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Registry\Adapter\Native is
 * the native adapter for the registry service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Registry\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Registry\Adapter;

/**
 * @see F/Technical/Registry/Adapter/Definition.php
 */
require_once 'F/Technical/Registry/Adapter/Definition.php';

/**
 * F\Technical\Registry\Adapter\Native is the native adapter
 * for the registry service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Registry\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
    /**
     * The list of current properties
     *
     * @var array
     */
    private $_properties = array();
    /**
     * Tests if specified property exist and has value
     *
     * @param string $key the property name
     *
     * @return bool true if exists (and has a value different from null)
     */
    public function hasProperty($key)
    {
        return true === isset($this->_properties[$key]);
    }
    /**
     * Returns the property value.
     *
     * @param string $key the property name
     *
     * @return mixed
     */
    public function getProperty($key)
    {
        return $this->_properties[$key];
    }
    /**
     * Sets the value for the specified property.
     *
     * @param string $key   the property name
     * @param mixed  $value the property value
     *
     * @return \F\Technical\Registry\Adapter\Native
     */
    public function setProperty($key, $value)
    {
        $this->_properties[$key] = $value;

        return $this;
    }
}
// @codeCoverageIgnoreEnd