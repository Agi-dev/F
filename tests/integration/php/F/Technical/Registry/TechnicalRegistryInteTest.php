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
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
class TechnicalRegistryInteTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Registry\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * getProperty
     */
    public function testGetPropertyForUnknownKeyThrowException()
    {
        $propertyKey = 'propertyKey';
        $this->setExpectedException('RuntimeException', "clef de registre 'propertyKey' inconnue", 404);
        $this->s()->getProperty($propertyKey);
    }
    /**
     * setProperty and getProperty
     */
    public function testSetAndGetPropertyWithSuccess()
    {
        $propertyKey = 'propertyKey';
        $propertyValue = 'propertyValue';

        $this->s()->setProperty($propertyKey, $propertyValue);
        $actual = $this->s()->getProperty($propertyKey);

        $this->assertEquals($propertyValue, $actual);
    }
}