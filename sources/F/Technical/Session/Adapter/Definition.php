<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Session\Adapter\Definition
 * is the adapter interface for the session service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package    F\Technical\Session\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Session\Adapter;

/**
 * F\Technical\Session\Adapter\Definition
 * is the adapter interface for the session service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Session\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
	 * Vérifie si une variable existe en session
	 * 
	 * @param string $varname
	 * 
	 * @return bool
	 */
	public function isVarnameExists($varname);
	
	/**
	 * Récupère une valeur en session
	 *
	 * @param string $varname
	 *
	 * @return mixed
	 */
	public function get($varname);
	
	/**
	 * Sauvegarde en session une variable
	 *
	 * @param string $varname
	 * @param mixed  $value
	 *
	 * @return \F\Technical\Session\Service
	 */
	public function set($varname, $value);
}
// @codeCoverageIgnoreEnd