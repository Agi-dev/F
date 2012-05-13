<?php
/**
 * F\Technical\I18n\Service is
 * a class to handle i18n operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François Schneider <fschneider.ext@orange.com>
 * @package    F\Technical\I18n\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\I18n;

/**
 *
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 *
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\I18n\Service is
 * a class to handle i18n operations.
 *
 * @category F
 * @package F\Technical\I18n
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class ServiceTest extends \F\Technical\Base\Test\Service
{

    /**
     *
     * @return F\Technical\I18n\Service
     */
    public function s ()
    {
        return parent::s();
    }

    /**
     *
     * @return F\Technical\I18n\Adapter\Mock
     */
    public function m ()
    {
        return parent::m();
    }

    /**
     * translate
     */
//     public function testTranslateWithI18nFileNotFoundReturnKey ()
//     {
//         $this->mock('fileExists', false);
//         $this->mock
//         $actual = $this->s()->translate('known.key');
//         $expected = 'known.key';
//         $this->assertEquals($expected, $actual);
//     }

    public function testTranslateWithUnknownKeyReturnKeyWithoutTheDot()
    {
        $this->mock('getI18nTranslation', 
                array('known.key' => 'Un joli message'));
        $this->assertEquals('unknown key', $this->s()->translate('unknown.key'));
    }

    public function testTranslateWithKnownKeyReturnString ()
    {
        $this->mock('getI18nTranslation', 
                array('known.key' => 'Un joli message'));
        $actual = $this->s()->translate('known.key');
        $expected = 'Un joli message';
        $this->assertEquals($expected, $actual);
    }

    public function testTranslateWithParameterReturnString ()
    {
        $this->mock('getI18nTranslation', 
                array('known.key' => 'Un joli message %{1} %{2}'));
        $actual = $this->s()->translate('known.key', array('param1', 'param2'));
        $expected = 'Un joli message param1 param2';
        $this->assertEquals($expected, $actual);
    }

    public function testTranslateWithParameterInversedOrderReturnString ()
    {
        $this->mock('getI18nTranslation', 
                array('known.key' => 'Un joli message %{2} %{1}'));
        $actual = $this->s()->translate('known.key', array('param1', 'param2'));
        $expected = 'Un joli message param2 param1';
        $this->assertEquals($expected, $actual);
    }

//     public function testTranslateWithParameterNotSetThrowRuntimeException ()
//     {
//         $this->mock('getI18nFile', 'unfichier');
//         $this->mock('fileExists', true);
//         $this->mock('getI18nTranslation', 
//                 array('known.key' => 'Un joli message %{1} %{2}'));
//         $this->setExpectedException('RuntimeException', 
//                 'unknown parameter 2 in "Un joli message param1 %{2}"');
//         $actual = $this->s()->translate('known.key', 'param1');
//     }

    /**
     * addI18nFile
     */
    
    public function testAddI18nFilePathDoesntExistThrowException ()
    {
        $this->mock('checkFileExists', new \RuntimeException('error fichier'));
        $filePath = 'nexistepas';
        $this->setExpectedException('RuntimeException', "error fichier");
        $this->s()->addI18nFile($filePath);
    }

    public function testAddI18nFileWithSuccess()
    {
    	$this->mock('checkFileExists');
    	$this->mock('getI18nContent', 'content');
    	$this->mock('addI18nTranslation');
    	$filePath = 'unfichier';
    	$actual = $this->s()->addI18nFile($filePath);
    	$this->assertInstanceOfService($actual);
    	$this->assertEquals(array('content'), $this->m()->getCallArgs('addI18nTranslation'));
    }
}