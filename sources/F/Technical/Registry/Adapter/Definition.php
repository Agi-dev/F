<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Registry\Adapter\Definition
 * is the adapter interface for the registry service.
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
 * F\Technical\Registry\Adapter\Definition
 * is the adapter interface for the registry service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Registry\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
     * Sets the value for the specified property in configuration.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     *
     * @throws Exception if an error occured
     */
    public function setProperty($key, $value);

    /**
     * Gets the value for the specified property in configuration.
     *
     * @param string $key
     *
     * @return mixed
     *
     */
    public function getProperty($key);

    /**
     * Tests if specified property exist and has value
     *
     * @param string $key the property name
     *
     * @return bool true if exists (and has a value different from null)
     */
    public function hasProperty($key);
}
// @codeCoverageIgnoreEnd