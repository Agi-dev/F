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
     * configure
     */
    public function testConfigureWithNotExistKeyLevelFileThrowException()
    {
        $this->mock('isFileExists', true);
        $this->mock('parseIniFile');
        $this->mock('isFileExists', false);
        $this->setExpectedException('RuntimeException',
            "le fichier 'notExistKeyLevelFile' n'existe pas", 404);

        // 3. executes the service method
        $this->s()->configure(array('keylevelfile' => 'notExistKeyLevelFile'));

        // 4. asserts
    }

    public function testConfigureWithSuccess()
    {
        $this->mock('isFileExists', true);
        $this->mock('parseIniFile');
        $this->mock('isFileExists', true);
        $this->mock('parseIniFile');

        $this->mock('configure');
        $this->s()->configure(array('file' => 'File'));
        $this->assertEquals(array(array('file' => 'File')),
            $this->m()->getCallArgs('configure'));
    }

    /**
     * trace
     */

    public function testTraceWithParamsNotAnArraySuccess()
    {
        // 1. set the mock behaviour
        $this->mock('getLevelForKey', 'err');
        $this->mock('getMsg', 'param 1 : paramOne');
        $this->mock('getDatetime', 'Today');
        $this->mock('write');

        // 3. executes the service method
        $this->s()->trace('valid.key', 'paramOne');

        // 4. asserts
        $this->assertEquals(array('valid.key', '[Today][ERR] param 1 : paramOne'."\n"),
            $this->m()->getCallArgs('write'));
        $this->assertEquals(array('valid.key', array('paramOne')), $this->m()->getCallArgs('getMsg'));
    }

    public function testTraceWithParamsSuccess()
    {
        // 1. set the mock behaviour
        $this->mock('getLevelForKey', 'err');
        $this->mock('getMsg', 'params : paramOne paramTwo');
        $this->mock('getDatetime', 'Today');
        $this->mock('write');

        // 3. executes the service method
        $this->s()->trace('valid.key', array ('paramOne', 'paramTwo'));

        // 4. asserts
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
}