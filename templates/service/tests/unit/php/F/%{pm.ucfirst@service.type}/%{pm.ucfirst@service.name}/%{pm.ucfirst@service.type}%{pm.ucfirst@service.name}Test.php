<?php
/**
 * F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service is
 * a class to handle %{pm.service.name} operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    %{pm.user.name} <%{pm.user.email}>
 * @package    F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Adapter
 * @copyright Copyright (c) %{pm.date@"Y"} <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name};

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service is
 * a class to handle %{pm.service.name} operations.
 *
 * @category F
 * @package F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}
 * @copyright  Copyright (c) %{pm.date@"Y"} <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class %{pm.ucfirst@service.type}%{pm.ucfirst@service.name}UnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * just for saying there is no test
     */
	public function testToImplement()
    {
    	$this->markTestIncomplete("Aucun test sur ce service !");
    }
}