<?php
/**
 * F\Technical\File\Service is
 * a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois <francoisschneider@neuf.fr>
 * @package    F\Technical\File\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\File;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\File\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * checkFileExists
     */
	public function testCheckFileExistsWithFileNotExistsThrowRuntimeException()
    {
    	$this->setExpectedException('RuntimeException', "le fichier 'fileNotExists' n'existe pas");
    	$actual= $this->s()->checkFileExists('fileNotExists');
    	$this->assertFalse($actual);
    }
    
	public function testCheckFileExistsWithSuccess()
    {
    	$actual = $this->s()->checkFileExists($this->getDataSetPath() . '/fileExists.txt');
    	$this->assertInstanceOfService($actual);
    }
    
    /**
     * isFileExists
     */
    public function testIsFileExistsWithFileNotExistReturnFalse()
    {
		$this->assertFalse($this->s()->isFileExists('fileNotExist'));
    }
    
    public function testIsFileExistsWithFileExistReturnTrue()
    {
    	$actual = $this->s()->isFileExists($this->getDataSetPath() . '/fileExists.txt');
    	$this->assertTrue($actual);
    }
    
    /**
     * parseIniFile
     */
    public function testParseIniFileWithSuccess()
    {
    	$expected = array(
    		'unedonnée'       => 'unevaleur',
			'uneautredonnée'  => 'uneautrevaleur',
			'unedonnée2'      => 'unevaleur',
			'uneautredonnée2' => 'uneautrevaleur'
    	);
    	$actual = $this->s()->parseIniFile($this->getDataSetPath() . '/fileIni.ini');
    	$this->assertEquals($expected, $actual);
    }
}