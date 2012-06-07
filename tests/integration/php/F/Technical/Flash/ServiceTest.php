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
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\Flash\Service
     */
    public function s()
    {
        return parent::s();
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
        $this->assertInstanceOfService($this->s()->flash('msg', 'success'));
    }

    /**
     * listFlash
     */
    public function testListFlashWithNoFlashReturnEmptyArray()
    {
    	$this->assertEquals(array(), $this->s()->listFlash());
    }

    public function testListFlashWithSuccess()
    {
        $this->s()->flash('first', 'success');
        $this->s()->flash('second', 'notice');
        $this->s()->flash('third', 'warning');
        $this->s()->flash('fourth', 'error');
        $expected = array(
            array('first' => 'success'),
            array('second' => 'notice'),
            array('third' => 'warning'),
            array('fourth' => 'error')
        );
        $actual = $this->s()->listFlash();
        $this->assertEquals($expected, $actual);
        // check there is no flash now
        $this->assertEquals(array(), $this->s()->listFlash(), 'flash should be empty after read');
    }


}