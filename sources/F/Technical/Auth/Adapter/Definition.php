<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Auth\Adapter\Definition
 * is the adapter interface for the auth service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Auth\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Auth\Adapter;

/**
 * F\Technical\Auth\Adapter\Definition
 * is the adapter interface for the auth service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Auth\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
     * Returns the identity or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity();

    /**
     * set identity
     *
     * @param mixed $identity
     *
     * @return F\Technical\Auth\Adapter\Definition
     */
    public function setIdentity($identity);
}
// @codeCoverageIgnoreEnd