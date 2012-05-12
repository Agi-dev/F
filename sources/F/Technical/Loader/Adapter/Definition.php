<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Loader\Adapter\Definition
 * is the adapter interface for the loader service.
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
 * F\Technical\Loader\Adapter\Definition
 * is the adapter interface for the loader service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Loader\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
     * Registers the specified function/method as an autoloader for classes.
     * 
     * @param string|array $function the function or method
     * 
     * @return bool true if succeed, false otherwise
     * 
     * @throws Exception if an error occured
     */
	public function registerAutoloadFunction($function);
    
	/**
	 * include file
	 *
	 * @param string $path
	 * 
	 * @return mixed
	 */
	public function php_require_once($path);
}
// @codeCoverageIgnoreEnd