<?php
/**
 * F\Technical\Registry\Service is
 * a class to handle registry operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Registry\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Registry;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Registry\Service is
 * a class to handle registry operations.
 *
 * @category F
 * @package F\Technical\Registry
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\Registry\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\Registry\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * getProperty
     */
    public function testGetPropertyForUnknownKeyThrowException()
    {
        $propertyKey = 'propertyKey';

        $this->mock('hasProperty', false);

        $this->setExpectedException('RuntimeException', "clef de registre 'propertyKey' inconnue", 404);

        $this->s()->getProperty($propertyKey);
    }

    public function testGetPropertyWithSuccess()
    {
        $propertyKey = 'propertyKey';
        $propertyValue = 'propertyValue';

        $this->mock('hasProperty', true);
        $this->mock('getProperty', $propertyValue);

        $result = $this->s()->getProperty($propertyKey);

        $this->assertEquals($propertyValue, $result);
        $this->assertEquals(array($propertyKey), $this->m()->getCallArgs('hasProperty'));
        $this->assertEquals(array($propertyKey), $this->m()->getCallArgs('getProperty'));
    }

    /**
     * setProperty
     */

    public function testSetPropertyNewKeyStoreValue()
    {
        $this->mock('setProperty', null);
        $this->s()->setProperty('newKey', 'theValue');
        $this->assertEquals(array('newKey', 'theValue'), $this->m()->getCallArgs('setProperty'));
    }
}