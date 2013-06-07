<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Flash\Adapter\Definition
 * is the adapter interface for the flash service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Flash\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Flash\Adapter;

/**
 * F\Technical\Flash\Adapter\Definition
 * is the adapter interface for the flash service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Flash\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
	 * add flash message
	 *
	 * @param string $msg
	 * @param string $priority
	 *
	 * @return \F\Technical\Flash\Adapter\Definition
	 */
	public function addFlash($msg, $priority);

	/**
     * Récupère la liste des messages flash
     *
     * @return array
     */
    public function listFlash();

    /**
     * Vide les flashs
     *
     * @return \F\Technical\Flash\Adapter\Definition
     */
    public function clearFlash();
    
   /**
     * Indique si des messages flash
     * 
     * @return boolean
     */
   public function isFlashExists();
}
// @codeCoverageIgnoreEnd