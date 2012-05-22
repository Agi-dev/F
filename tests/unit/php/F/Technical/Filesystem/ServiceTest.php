<?php
/**
 * F\Technical\Filesystem\Service is
 * a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François <francoisschneider@neuf.fr>
 * @package    F\Technical\Filesystem\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Filesystem;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Filesystem\Service is
 * a class to handle file operations.
 *
 * @category F
 * @package F\Technical\Filesystem
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\Filesystem\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\Filesystem\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * checkFileExists
     */
	public function testCheckFileExistsWithFileNotExistsThrowRuntimeException()
    {
    	$this->mock('isFileExists', false);
    	$this->setExpectedException('RuntimeException', "le fichier 'fileNotExists' n'existe pas");
    	$this->s()->checkFileExists('fileNotExists');
    }

	public function testCheckFileExistsWithSuccess()
    {
    	$this->mock('isFileExists', true);
    	$actual = $this->s()->checkFileExists('fileExists');
    	$this->assertInstanceOfService($actual);
    }

    /**
     * isFileExists
     */
    public function testIsFileExistsWithFileNotExistReturnFalse()
    {
		$this->mock('isFileExists', false);
		$this->assertFalse($this->s()->isFileExists('fileNotExist'));
    }

    public function testIsFileExistsWithFileExistReturnTrue()
    {
    	$this->mock('isFileExists', true);
		$this->assertTrue($this->s()->isFileExists('fileExist'));
    }

    /**
     * parseIniFile
     */
    public function testParseIniFileWithFileNotExistsThrowRuntimeException()
    {
    	$this->mock('isFileExists', false);
    	$this->setExpectedException('RuntimeException', "le fichier 'fileIni' n'existe pas");
    	$this->s()->parseIniFile('fileIni');
    }

    public function testParseIniFileWithSuccess()
    {
    	$this->mock('isFileExists', true);
    	$this->mock('parseIniFile', 'somedata');
    	$actual = $this->s()->parseIniFile('fileIni');
    	$this->assertEquals('somedata', $actual);
    }

    /**
     * appendFile
     */
    public function testAppendFileWithSuccess()
    {
    	$this->mock('fopen', 'une resource');
    	$actual = $this->s()->appendFile('fichier');
    	$this->assertEquals('une resource', $actual);
    }

    /**
     * writeResource
     */
    public function testWriteResourceWithBadResourceThrowRuntimeException()
    {
    	$this->mock('is_resource', false);
    	$this->setExpectedException('RuntimeException', "la resource fichier est null ou incorrect");
    	$this->s()->writeResource('bad resource', 'content');
    }

    public function testWriteResourceWithSuccess()
    {
    	$this->mock('is_resource', true);
    	$this->mock('fwrite', 6);
    	$actual = $this->s()->writeResource('bad resource', 'content');
    	$this->assertEquals(6, $actual);
    	$this->assertEquals(array('bad resource'), $this->m()->getCallArgs('is_resource'));
    }

    /**
     * checkResource
     */
    public function testCheckResourceWithBadResourceThrowRuntimeException()
    {
    	$this->mock('is_resource', false);
    	$this->setExpectedException('RuntimeException', "la resource fichier est null ou incorrect");
    	$this->s()->checkResource('bad resource');
    }


    public function testCheckResourceWithSuccess()
    {
    	$this->mock('is_resource', true);
    	$this->assertInstanceOfService($this->s()->checkResource('une resource'));
    }

    /**
     * closeResource
     */
    public function testClosekResourceWithSuccess()
    {
    	$this->mock('is_resource', true);
    	$this->mock('fclose', true);
    	$this->assertTrue($this->s()->closeResource('une resource'));
    	$this->assertEquals(array('une resource'), $this->m()->getCallArgs('fclose'));
    }

    /**
     * getFileContent
     */
    public function testGetFileContentsWithFileNotFoundThrowRuntimeException()
    {
    	$this->mock('isFileExists', false);
    	$this->setExpectedException('RuntimeException', "le fichier 'fileNotExist' n'existe pas");
    	$this->s()->getFileContents('fileNotExist');
    }

    public function testGetFileContentsWithSuccess()
    {
    	$this->mock('isFileExists', true);
    	$this->mock('getFileContents', 'un contenu de fichier');
        $actual = $this->s()->getFileContents('fileExist');
        $this->assertEquals("un contenu de fichier", $actual);
    }
}