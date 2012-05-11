<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\I18n\Adapter\Native is
 * the native adapter for the i18n service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François Schneider <fschneider.ext@orange.com>
 * @package    F\Technical\I18n\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\I18n\Adapter;

/**
 *
 * @see F/Technical/I18n/Adapter/Definition.php
 */
require_once 'F/Technical/I18n/Adapter/Definition.php';

/**
 *
 * @see F/Technical/Base/Adapter/Native.php
 */
require_once 'F/Technical/Base/Adapter/Native.php';

/**
 * F\Technical\I18n\Adapter\Native is the native adapter
 * for the i18n service, that implements PHP natives primitives.
 *
 * @category W
 * @package F\Technical\I18n\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Native implements Definition
{

    /**
     * Liste des traductions 'clef' => valeur
     *
     * @var array
     */
    private $_i18n;

    public function __construct()
    {
        // traduction de la lib
        $this->_i18n = $this->getI18nContent(
                        realpath(dirname(__FILE__) . '/../../resources/fr_FR.php'));
    }

    /*
     * (non-PHPdoc) @see F\Technical\I18n\Adapter.Definition::fileExists()
     */
    public function fileExists ($filename)
    {
        return file_exists($filename);
    }

    /*
     * (non-PHPdoc) @see F\Technical\I18n\Adapter.Definition::addI18nFile()
     */
    public function addI18nTranslation($newI18n)
    {
        $this->_i18n = array_merge($this->_i18n, $newI18n);
        return $this;
    }

    /*
     * (non-PHPdoc) @see F\Technical\I18n\Adapter.Definition::isFile()
     */
    public function isFile($filename)
    {
        return is_file($filename);
    }

    /*
     * (non-PHPdoc) @see
     * F\Technical\I18n\Adapter.Definition::getI18nTranslation()
     */
    public function getI18nTranslation()
    {
        return $this->_i18n;
    }
    /*
     * (non-PHPdoc) @see
     * F\Technical\I18n\Adapter.Definition::getI18nIniContent()
     */
    public function getI18nContent ($filename)
    {
        return include($filename);
    }

}
// @codeCoverageIgnoreEnd