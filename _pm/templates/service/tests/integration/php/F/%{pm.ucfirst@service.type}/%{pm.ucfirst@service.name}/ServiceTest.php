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
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name}\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * just for saying there is no test
     */
    public function testToImplement()
    {
    	$this->markTestIncomplete("Aucun test sur ce service !");
    }
}