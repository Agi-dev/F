<?php
/**
 * F\Technical\File\Service is
 * a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François <francoisschneider@neuf.fr>
 * @package    F\Technical\File\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\File;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\File\Service is
 * a class to handle file operations.
 *
 * @category F
 * @package F\Technical\File
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\File\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\File\Adapter\Mock
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
}