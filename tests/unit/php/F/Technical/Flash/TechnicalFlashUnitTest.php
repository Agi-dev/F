<?php
/**
 * F\Technical\Flash\Service is
 * a class to handle flash operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Flash\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Flash;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Flash\Service is
 * a class to handle flash operations.
 *
 * @category F
 * @package F\Technical\Flash
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class TechnicalFlashUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Flash\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Flash\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * flash
     */
	public function testFlashWithUnknownPriorityThrowRuntimeException()
    {
    	$this->setExpectedException('RuntimeException', "la priorité de flash 'unknown' est inconnue");
    	$this->s()->flash('msg', 'unknown');
    }

    public function testFlashWithSuccess()
    {
    	$this->mock('addFlash');
    	$this->assertInstanceOfService($this->s()->flash('msg', 'success'));
    }

    /**
     * listFlash
     */
    public function testListFlashWithSuccess()
    {
    	$this->mock('listFlash', 'des flashs');
    	$this->mock('clearFlash');
        $this->assertEquals('des flashs', $this->s()->listFlash());
    }
    
    /**
     * isFlashExists
     */
    public function testIsFlashExistsWithNoFlashReturnFalse()
    {
    	$this->mock('isFlashExists', false);
    	$this->assertFalse($this->s()->isFlashExists());
    }
    
    public function testIsFlashExistsWithFlashReturnTrue()
    {
    	$this->mock('isFlashExists', true);
    	$this->assertTrue($this->s()->isFlashExists());
    }
}