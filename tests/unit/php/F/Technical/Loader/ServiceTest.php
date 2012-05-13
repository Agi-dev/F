<?php
/**
 * F\Technical\Loader\Service is
 * a class to handle loader operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Loader\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Loader;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Loader\Service is
 * a class to handle loader operations.
 *
 * @category F
 * @package F\Technical\Loader
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\Loader\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\Loader\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * autoload
     */
	public function testAutoloadWithErrorThrowRuntimeException()
	{
		$this->mock('registerAutoloadFunction', new \Exception('une error'));
		$this->setExpectedException('RuntimeException', "impossible de charger l'autoload");
		$this->s()->autoload();
	}
	
	public function testAutoloadWithSuccess()
    {
    	$this->mock('registerAutoloadFunction', true);
    	$this->assertInstanceOfService($this->s()->autoload());
    }
    
    /**
     * load
     */
    public function testLoadWithSuccess()
    {
    	$this->mock('php_require_once');
    	$this->assertInstanceOfService($this->s()->load('uneclass'));
    	$this->assertEquals(array('uneclass.php'), $this->m()->getCallArgs('php_require_once'));
    }
    
}