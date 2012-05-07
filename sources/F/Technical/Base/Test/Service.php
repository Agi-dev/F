<?php
/**
 * F\Technical\Base\Test\Service is a class to handle tests operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Base
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Test;
use RuntimeException;

/**
 * @see F/Technical/Base/Test/Base.php
 */
require_once 'F/Technical/Base/Test/Base.php';

/**
 * F\Technical\Base\Test\Service is a class to handle tests operations.
 *
 * @category F
 * @package F\Technical\Base\Test
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
abstract class Service
    extends \F\Technical\Base\Test\Base
{
    /**
     * @var mixed
     */
    protected $_mockAdapter;
    /**
     * Set-ups the unit test
     */
    public function setUp()
    {
        $mockClass = str_replace(
         '/',
         '\\',
            dirname(str_replace('\\', '/', $this->getServiceClass()))
        ) . '\\Adapter\Mock';
        $serviceClass = $this->getServiceClass();

        require_once str_replace('\\', '/', $mockClass) . '.php';
        require_once str_replace('\\', '/', $serviceClass) . '.php';


        $this->_mockAdapter = new $mockClass;
        if (true === method_exists($this, 'setUpMockAdapter')) {
            $this->setupMockAdapter($this->_mockAdapter);
        }
        $this->_service = new $serviceClass($this->_mockAdapter);
    }
    /**
     * Returns the mock adapter of the tested service instance.
     *
     * @return mixed
     */
    public function m()
    {
        return $this->_mockAdapter;
    }
    /**
     * Returns the mock adapter for the unit-tested service
     *
     * @return mixed
     */
    public function getMockAdapter()
    {
        return $this->_mockAdapter;
    }
    /**
     * Mocks the specified method of the underlying adapter.
     *
     * @param string $methodName     the adapter method name
     * @param mixed  $expectedReturn the expected adapter method result
     *
     * @return F\Technical\Base\Test\Service
     */
    public function mock($methodName, $expectedReturn = null)
    {
        $this->getMockAdapter()->mock($methodName, $expectedReturn);

        return $this;
    }
    /**
     * Call Mock Adapter Method
     * @param string $method
     * @throws RuntimeException
     */
    public function assertAdapterCalled($method)
    {
        try
        {
            $this->getMockAdapter()->getMethodCall($method, 0);
        } catch ( RuntimeException $e )
        {
            if (404 === $e->getCode()) {
                $this->fail("No call registered for method '$method'");
            }
            throw $e;
        }
    }
    /**
     * Test Factory
     */
    public function testFactoryForAllCasesReturnsNewServiceInstance()
    {
        $serviceClass = $this->getServiceClass();

        $instanceOne = call_user_func(array($serviceClass, 'factory'));
        $instanceTwo = call_user_func(array($serviceClass, 'factory'));

        $instanceOne->testProperty = 'value1';
        $instanceTwo->testProperty = 'value2';

        $this->assertNotEquals($instanceOne->testProperty, $instanceTwo->testProperty);
        $this->assertEquals('value1', $instanceOne->testProperty);
        $this->assertEquals('value2', $instanceTwo->testProperty);
    }
    /**
     * Test singleton
     */
    public function testSingletonForAllCasesReturnsSameServiceInstance()
    {

        $serviceClass = $this->getServiceClass();
        $instanceOne = call_user_func(array($serviceClass, 'singleton'));
        $instanceTwo = call_user_func(array($serviceClass, 'singleton'));

        $instanceOne->testProperty = 'value1';
        $instanceTwo->testProperty = 'value2';

        $this->assertEquals($instanceOne->testProperty, $instanceTwo->testProperty);
        $this->assertEquals('value2', $instanceOne->testProperty);
        $this->assertEquals('value2', $instanceTwo->testProperty);
    }

    /**
     * test if actual is instance of current service
     *
     * @param $actual
     *
     *
     */
    public function assertInstanceOfService($actual)
    {
    	$this->assertInstanceOf(get_class($this->s()), $actual);
    }
}