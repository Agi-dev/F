<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Trace\Adapter\Definition
 * is the adapter interface for the trace service.
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
 * F\Technical\Trace\Adapter\Definition
 * is the adapter interface for the trace service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Trace\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
    /**
     * Sets the specified list of levels.
     *
     * @param array $levels the levels
     *
     * @return P\Technical\Trace\Adapter\Native
     *
     * @throws Exception if an error occured
     */
    public function setLevelForKeys($levels);

    /**
     * Returns the current level for the specified key.
     *
     * @param string $key the key
     *
     * @return string
     *
     * @throws Exception if an error occured
     */
    public function getLevelForKey($key);

    /**
     * get date time
     *
     * @return string
     */
    public function getDatetime();

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
    public function write($key, $msg);

    /**
     * test if file exist
     *
     * @param string $filename
     *
     * @return bool
     */
    public function isFileExists($filename);

    /**
     * parse ini file
     *
     * @param string $filename
     *
     * @return array
     */
    public function parseIniFile($filename);

    /**
     * Get message
     *
     * @param string $key
     *
     * @param array $params
     *
     * @return string
     */
    public function getMsg($key, $params);
}
// @codeCoverageIgnoreEnd