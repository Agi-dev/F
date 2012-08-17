<?php
/**
 * F\Technical\Acl\Service is
 * a class to handle acl operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Acl\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Acl;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\Acl\Service is
 * a class to handle acl operations.
 *
 * @category F
 * @package F\Technical\Acl
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Acl\Service
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
    	$this->markTestIncomplete();
    }
}