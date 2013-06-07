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
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

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
class TechnicalSessionUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Session\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Session\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * get
     */
    public function testGetWithUnknownVarnameThrowRuntimeException()
    {
    	$this->mock('isVarnameExists', false);
    	$this->setExpectedException('RuntimeException', "Variable de session 'unknown' inconnue");
    	$this->s()->get('unknown');
    }
    
    public function testGetWithSuccess()
    {
    	$this->mock('isVarnameExists', true);
    	$this->mock('get', 'session');
    	$this->assertEquals('session', $this->s()->get('var'));
    }
    
    /**
     * set
     */
    public function testSetWithSuccess()
    {
    	$this->mock('set');
    	$this->assertInstanceOfService( $this->s()->set('var', 'une valeur'));
    	$this->assertEquals(array('var', 'une valeur'), $this->m()->getCallArgs('set'));
    }
    
}