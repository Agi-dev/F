<?php
/**
 * F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service is a class to handle %{pm.service.name} operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    %{pm.user.name} <%{pm.user.email}>
 * @package   F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}
 * @copyright Copyright (c) %{pm.date@"Y"} <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name};

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service is a class to handle %{pm.service.name} operations.
 *
 * @category F
 * @package F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}
 * @copyright Copyright (c) %{pm.date@"Y"} <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
	/**
	 * Returns the singleton of this service
	 *
	 * @return \F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
}