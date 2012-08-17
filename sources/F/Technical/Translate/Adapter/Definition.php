<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Translate\Adapter\Definition
 * is the adapter interface for the translate service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Translate\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Translate\Adapter;

/**
 * F\Technical\Translate\Adapter\Definition
 * is the adapter interface for the translate service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Translate\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
     * Returns the specified key value.
     *
     * @param string $key the key
     *
     * @return string
     */
    public function getKey($key, $locale);

    /**
     * get Current locale
     *
     * @return string
     */
    public function getCurrentLocale();

    /**
     * get Current locale
     *
     * @return W_Technical_Translate_Adapter_Interface
     */
    public function setCurrentLocale($locale);

    /**
     * test if file exist
     *
     * @param string $filename
     *
     * @return bool
     */
    public function isFileExists($filename);

    /**
     * Adds the specified path as a translation directory
     *
     * @param string $path the translation directory
     *
     * @return \F\Technical\Translate\Definition
     *
     * @throws Exception if an error occured
     */
    public function addRepository($path);

    /**
     * check path exists
     *
     * @param $path
     *
     * @return \F\Technical\Translate\Definition
     *
     * @throw RuntimeException
     */
    public function checkDirExists($path);

}
// @codeCoverageIgnoreEnd