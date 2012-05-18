<?php
/**
 * F\Technical\Translate\Service is
 * a class to handle translate operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Translate\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Translate;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Translate\Service is
 * a class to handle translate operations.
 *
 * @category F
 * @package F\Technical\Translate
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\Translate\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\Translate\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * translate
     */
	function testTranslateWithUnknownKeyReturnKeyWithoutDot()
    {
        $this->mock('checkDirExists', $this->s()->getAdapter());
        $this->mock('getCurrentLocale', 'fr_FR');
        $this->mock('getKey', null);
        $this->assertEquals('unknow Key', $this->s()->translate('unknow.Key'));
    }

    function testTranslateWithKnownKeySuccess()
    {
        $this->mock('checkDirExists', $this->s()->getAdapter());
        $this->mock('getCurrentLocale', 'fr_FR');
        $this->mock('getKey','Default Lang Message');
        $this->assertEquals('Default Lang Message', $this->s()->translate('knownKey'));
    }

    function testTranslateWithKnownKeyAndParamsSuccess()
    {
        $this->mock('checkDirExists', $this->s()->getAdapter());
        $this->mock('getCurrentLocale', 'fr_FR');
        $this->mock('getKey', 'Message param[0]=%{1} and param[1]=%{2}');

        $this->assertEquals('Message param[0]=paramOne and param[1]=paramTwo',
            $this->s()->translate('knownKey', array('paramOne', 'paramTwo')));
        $this->assertEquals(array('knownKey', 'fr_FR'), $this->m()->getCallArgs('getKey'));
    }

     public function testTranslateWithParameterInversedOrderSuccess()
     {
     	$this->mock('checkDirExists', $this->s()->getAdapter());
        $this->mock('getCurrentLocale', 'fr_FR');
        $this->mock('getKey', 'Message param[0]=%{2} and param[1]=%{1}');

        $this->assertEquals('Message param[0]=paramOne and param[1]=paramTwo',
            $this->s()->translate('knownKey', array('paramTwo', 'paramOne')));
        $this->assertEquals(array('knownKey', 'fr_FR'), $this->m()->getCallArgs('getKey'));
     }

    /**
     * addRepository
     */
    function testAddRepositoryWithNotExistsThrowException()
    {
        $this->mock('checkDirExists', new \RuntimeException("dir 'noDir' not found", 404));
        $this->setExpectedException('RuntimeException', "dir 'noDir' not found", 404);
        $this->s()->addRepository('noDir');
    }

    function testAddRepositoryWithSuccess()
    {
        $this->mock('checkDirExists', $this->s()->getAdapter());
        $this->mock('addRepository');
        $this->assertInstanceOfService($this->s()->addRepository('dir'));
    }
}