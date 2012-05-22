<?php
// @codeCoverageIgnoreStart
/**
 * P\Technical\Base\Adapter\Native is the native adapter
 * for the service.
 *
  * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Base
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Adapter;

/**
 * F\Technical\Base\Adapter\Native is the native adapter
 * for the service.
 *
 * @category F
 * @package F\Technical\Base\Adapter
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
abstract class Native
{
    /**
     *
     * Enter description here ...
     * @param unknown_type $key
     * @param unknown_type $params
     */
	public function trace($key, $params)
    {
    	return \F\Technical\Trace\Service::singleton()->trace($key, $params);
    }
}
// @codeCoverageIgnoreEnd