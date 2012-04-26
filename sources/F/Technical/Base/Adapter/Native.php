<?php
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
abstract class Native {
	public function __call($method, $args) {
		throw new \RuntimeException('Method "'.$method.'" not yet implemented');
	}
}