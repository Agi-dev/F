<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Translate\Adapter\Native is
 * the native adapter for the translate service,
 * that implements PHP natives primitives.
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
 * @see F/Technical/Translate/Adapter/Definition.php
 */
require_once 'F/Technical/Translate/Adapter/Definition.php';

/**
 * F\Technical\Translate\Adapter\Native is the native adapter
 * for the translate service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Translate\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
    /**
     * Current locale.
     *
     * @var string
     */
    private $_locale;
    /**
     * List of all available keys for all locales.
     *
     * @var array
     */
    private $_keys;

    /**
     * list of repositories
     *
     * @var array
     */
    private $_repositories;

    /**
     * Init de base
     *
     */
    function __construct()
    {
        $this->_locale = 'fr_FR';
        $this->_keys   = array();
        $this->addRepository(
            realpath(dirname(__FILE__) . '/../../resources/i18n'));
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Translate\Adapter.Definition::getKey()
     */
    public function getKey($key, $locale)
    {
        if ( true === isset($this->_keys[$locale][$key]) ) {
            return $this->_keys[$locale][$key];
        }
        return null;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Translate\Adapter.Definition::getCurrentLocale()
     */
    public function getCurrentLocale()
    {
        return $this->_locale;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Translate\Adapter.Definition::setCurrentLocale()
     */
    public function setCurrentLocale($locale)
    {
        $this->_locale = $locale;
        return $this;
    }

    /**
     * Include file
     *
     * @return array
     */
    public function includeFile($filename)
    {
        return include $filename;
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
        return \F\Technical\Filesystem\Service::singleton()->isFileExists($filename);
    }

    /**
     * Adds the specified path as a translation directory
     *
     * @param string $path the translation directory
     *
     * @return P\Technical\I18n\Service
     *
     * @throws Exception if an error occured
     */
    public function addRepository($path)
    {
        if (true === isset($this->_repositories[$path])) {
            return $this;
        }


        if (false === is_dir($path)) {
            return $this;
        }

        foreach(scandir($path) as $f) {
            if ('.' === $f || '..' === $f) {
                continue;
            }

            $matches = null;
            $lastPointPos = strrpos($f, '.');
            $ext = '';
            if (false !== $lastPointPos) {
                $ext = substr($f, $lastPointPos + 1);
            }
            $locale = null;
            $newKeys = null;


            if (0 >= preg_match('|^([a-z0-9]{2,3}\_[a-z0-9]{2,3})\.php$|i', $f, $matches)) {
                continue;
            }
            $locale = $matches[1];
            if (false === isset($this->_keys[$locale])) {
                $this->_keys[$locale] = array();
            }
            $newKeys = include $path . '/' . $f;

            if (null === $newKeys || false === is_array($newKeys)) {
                continue;
            }
            $this->_keys[$locale] = array_merge($this->_keys[$locale], $newKeys);

        }

        $this->_repositories[$path] = true;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Translate\Adapter.Definition::checkDirExists()
     */
    public function checkDirExists($path)
    {
    	\F\Technical\Filesystem\Service::singleton()->checkDirExists($path);
    	return $this;
    }
}
// @codeCoverageIgnoreEnd