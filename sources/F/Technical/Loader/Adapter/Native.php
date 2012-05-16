<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Loader\Adapter\Native is
 * the native adapter for the loader service,
 * that implements PHP natives primitives.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Loader\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Loader\Adapter;

/**
 * @see F/Technical/Loader/Adapter/Definition.php
 */
require_once 'F/Technical/Loader/Adapter/Definition.php';

/**
 * F\Technical\Loader\Adapter\Native is the native adapter
 * for the loader service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Loader\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * (non-PHPdoc)
	 * @see sources/F/Technical/Loader/Adapter/F\Technical\Loader\Adapter.Definition::registerAutoloadFunction()
	 */
	public function registerAutoloadFunction($function)
    {
        $err1   = error_get_last();
        $result = @spl_autoload_register($function);
        $err    = error_get_last();

        if (false === $result && (serialize($err1) !== serialize($err))) {
            throw new \RuntimeException($err['message'], 1000 + $err['type']);
        }

        return true === $result;
    }

    /**
     * (non-PHPdoc)
     * @see sources/F/Technical/Loader/Adapter/F\Technical\Loader\Adapter.Definition::php_require_once()
     */
	public function php_require_once($path)
    {
       return require_once $path;
    }
}
// @codeCoverageIgnoreEnd