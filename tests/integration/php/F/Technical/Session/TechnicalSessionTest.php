<?php
/**
 * F\Technical\Session\Service is
 * a class to handle session operations.
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

namespace F\Technical\Session;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\Session\Service is
 * a class to handle session operations.
 *
 * @category F
 * @package F\Technical\Session
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class TechnicalSessionInteTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Session\Service
     */
    public function s()
    {
        return parent::s();
    }
    
    /**
     * set - get
     */
    public function testSetAndGetWithSuccess()
    {
    	$this->s()->set('var', 'des données');
    	$this->assertEquals('des données', $this->s()->get('var'));
    }
}