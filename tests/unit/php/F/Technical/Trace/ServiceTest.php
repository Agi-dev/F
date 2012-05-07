<?php
/**
 * F\Technical\Trace\Service is
 * a class to handle trace operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Trace\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Trace;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Trace\Service is
 * a class to handle trace operations.
 *
 * @category F
 * @package F\Technical\Trace
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\Trace\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\Trace\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

	/**
	 * setTraceEnabled
	 */
	public function testSetTraceEnabledWithNoTrueParamDisableTrace()
	{
		$this->mock('setTraceEnabled');
		$this->assertInstanceOfService($this->s()->setTraceEnabled('unechaine'));
		$this->assertEquals(array(false), $this->m()->getCallArgs('setTraceEnabled'));

	}

	public function testSetTraceEnabledWithSuccess()
	{
    	$this->mock('setTraceEnabled');
		$this->assertInstanceOfService($this->s()->setTraceEnabled(true));
        $this->assertEquals(array(true), $this->m()->getCallArgs('setTraceEnabled'));
	}

	/**
     * isTraceEnabled
     */
    public function testIsTraceEnabledWithSuccess()
    {
        $this->mock('isTraceEnabled', true);
        $this->assertTrue($this->s()->isTraceEnabled());
    }

    /**
     * configure
     */
    public function testConfigureWithTraceSuccess()
    {
    	$config = array (
            'activated' => 1,
            'file' => 'afile',
            'keylevelfile' =>'TraceLevelKeyMessage',
        );
        $this->mock('checkFileExists', true);
        $this->mock('parseIniFile', 'someData');
        $this->mock('checkFileExists', true);
        $this->mock('parseIniFile', 'otherData');
        $this->mock('setTraceEnabled');
        $this->mock('setFile');
    	$this->assertInstanceOfService($this->s()->configure('someparams'));
    }



    /**
     * loadLevelsFromFile
     */
    public function testLoadLevelsFromFileWithNotExistKeyLevelFileThrowException()
    {
        $this->mock('checkFileExists', new \RuntimeException('erreur'));
        $this->setExpectedException('RuntimeException',
            'erreur');

        $this->s()->loadLevelsFromFile('notExistKeyLevelFile');
    }

    public function testLoadLevelsFromFileWithSuccess()
    {
    	$this->mock('checkFileExists', true);
    	$this->mock('parseIniFile', 'someData');

    	$this->assertInstanceOfService($this->s()->loadLevelsFromFile('keyLevelFile'));
    }

    /**
     * trace
     */

    public function testTraceWithParamsNotAnArraySuccess()
    {
        $this->mock('getLevelForKey', 'err');
        $this->mock('getMsg', 'param 1 : paramOne');
        $this->mock('getDatetime', 'Today');
        $this->mock('write');

        $this->s()->trace('valid.key', 'paramOne');

        $this->assertEquals(array('valid.key', '[Today][ERR] param 1 : paramOne'."\n"),
            $this->m()->getCallArgs('write'));
        $this->assertEquals(array('valid.key', array('paramOne')), $this->m()->getCallArgs('getMsg'));
    }

    public function testTraceWithParamsSuccess()
    {
        $this->mock('getLevelForKey', 'err');
        $this->mock('getMsg', 'params : paramOne paramTwo');
        $this->mock('getDatetime', 'Today');
        $this->mock('write');

        $this->s()->trace('valid.key', array ('paramOne', 'paramTwo'));

        $this->assertEquals(array('valid.key', '[Today][ERR] params : paramOne paramTwo'."\n"),
            $this->m()->getCallArgs('write'));
        $this->assertEquals(array('valid.key', array ('paramOne', 'paramTwo')), $this->m()->getCallArgs('getMsg'));
    }

    public function testTraceWithNoKeyLevelSetSuccess()
    {
        // 1. set the mock behaviour
        $this->mock('getLevelForKey', null);
        $this->mock('getMsg', 'message without key level set');
        $this->mock('getDatetime', 'Today');
        $this->mock('write');

        // 3. executes the service method
        $this->s()->trace('valid.key', array('paramOne', 'paramTwo'));

        // 4. asserts
        $this->assertEquals(array('valid.key', '[Today][VALID.KEY] message without key level set'."\n"),
            $this->m()->getCallArgs('write'));
    }

    public function testTraceWithOnlyWarningMessageFilterSuccess()
    {

    }

    public function testTraceWithoutWarningMessageFilterSuccess()
    {

    }
}