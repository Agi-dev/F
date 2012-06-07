<?php
/**
 * F\Technical\Auth\Service is
 * a class to handle auth operations.
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

namespace F\Technical\Auth;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\Auth\Service is
 * a class to handle auth operations.
 *
 * @category F
 * @package F\Technical\Auth
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\Auth\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * hasIdentity
     */
    public function testHasIdentityWithUserNotAuthenticateReturnFalse()
    {
        $this->assertFalse($this->s()->hasIdentity());
    }

    public function testHasIdentityWithUserAuthenticateReturnTrue()
    {
        $this->s()->getAdapter()->setIdentity('identity');
    	$this->assertTrue($this->s()->hasIdentity());
    }
}