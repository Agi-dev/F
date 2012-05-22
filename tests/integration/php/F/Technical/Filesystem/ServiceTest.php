<?php
/**
 * F\Technical\Filesystem\Service is
 * a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois <francoisschneider@neuf.fr>
 * @package    F\Technical\Filesystem\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Filesystem;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\Filesystem\Service
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

    /**
     * appendFile
     */
    public function testAppendFileWithSuccess()
    {
    	$filename = $this->getDataSetPath() . '/file.txt';
    	$actual = $this->s()->appendFile($filename);
    	$this->assertFileExists($filename);
    	$this->assertInternalType('resource', $actual);
    	fclose($actual);
    	unlink($filename);
    }

    /**
     * checkResource
     */
    public function testCheckResourceWithBadResourceThrowRuntimeException()
    {
    	$this->setExpectedException('RuntimeException', "la resource fichier est null ou incorrect");
    	$this->s()->checkResource('bad resource');
    }


    public function testCheckResourceWithSuccess()
    {
    	$filename = $this->getDataSetPath() . '/file.txt';
    	$resource = $this->s()->appendFile($filename);
    	$this->assertInstanceOfService($this->s()->checkResource($resource));
    	fclose($resource);
    	unlink($filename);
    }

    /**
     * writeResource
     */
    public function testWriteResourceWithBadResourceThrowRuntimeException()
    {
    	$this->setExpectedException('RuntimeException', "la resource fichier est null ou incorrect");
    	$this->s()->WriteResource('bad resource', 'un contenu');
    }

    public function testWriteResourceWithSuccess()
    {
    	$filename = $this->getDataSetPath() . '/file.txt';
    	$resource = $this->s()->appendFile($filename);
    	$content = 'une phrase de test';
    	$actual = $this->s()->writeResource($resource, $content);
    	$this->assertEquals(strlen($content), $actual);
    	fclose($resource);
    	$this->assertEquals($content, file_get_contents($filename));
    	unlink($filename);
    }

    /**
     * fclose
     */
    public function testClosekResourceWithSuccess()
    {
    	$filename = $this->getDataSetPath() . '/file.txt';
    	$resource = $this->s()->appendFile($filename);
    	$this->assertTrue($this->s()->closeResource($resource));
    	unlink($filename);

    }


    /**
     * getFileContent
     */
    public function testGetFileContentWithFileNotFoundThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', "le fichier 'fileNotExists' n'existe pas");
        $this->s()->getFileContents('fileNotExists');
    }

    public function testGetFileContentWithSuccess()
    {
        $actual = $this->s()->getFileContents($this->getDataSetPath() . '/fileExists.txt');
        $this->assertEquals("Ce fichier existe bien\net même sur plusieurs\nlignes.", $actual);
    }
}