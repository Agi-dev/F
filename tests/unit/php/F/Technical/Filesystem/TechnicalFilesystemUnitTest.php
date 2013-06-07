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
class TechnicalFilesystemUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Filesystem\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Filesystem\Adapter\Mock
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
    public function testCloseResourceWithSuccess()
    {
    	$this->mock('is_resource', true);
    	$this->mock('fclose', true);
    	$this->assertTrue($this->s()->closeResource('une resource'));
    	$this->assertEquals(array('une resource'), $this->m()->getCallArgs('fclose'));
    }

    public function testCloseResourceWithNoResourceReturnTrue()
    {
        $this->mock('is_resource', false);
        $this->assertTrue($this->s()->closeResource('une resource'));
        $this->assertEquals(0, $this->m()->countCalls('fclose'));
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

    /**
     * checkDirExist
     */
    public function testCheckDirExistsWithDirNotExistThrowRuntimeException()
    {
    	$this->mock('isFileExists', false);
    	$this->setExpectedException('RuntimeException', "le répertoire 'dirNotExist' n'existe pas");
        $this->s()->checkDirExists('dirNotExist');
    }

    public function testCheckDirExistsWithSuccess()
    {
    	$this->mock('isFileExists', true);
    	$this->assertInstanceOfService($this->s()->checkDirExists('dirExist'));
    }
    
    /**
     * getFileSize
     */
    public function testGetFileSizeWithFileNotFoundThrowRuntimeException()
    {
    	$this->mock('isFileExists', false);
    	$this->setExpectedException('RuntimeException', "le fichier 'fileNotExist' n'existe pas");
    	$this->s()->getFileSize('fileNotExist');
    }
    
    public function testGetFileSizeWithSuccess()
    {
    	$this->mock('isFileExists', true);
    	$this->mock('getFileSize', '10000');
    	$actual = $this->s()->getFileSize('fileExist');
    	$this->assertEquals("10000", $actual);
    }
    
    /**
     * getFileExtension
     */
    public function testGetFileExtensionWithSuccess()
    {
    	$actual = $this->s()->getFileExtension('sfksd/dflkd/toto.txt');
    	$this->assertEquals('txt', $actual);
    }
    
    /**
     * copyFile
     */
    public function testCopyFileWithSourceNotFoundThrowRuntimeException()
    {
    	$this->mock('isFileExists', false);
    	$this->setExpectedException('RuntimeException', "le fichier 'fileNotExist' n'existe pas", 404);
    	$this->s()->copyFile('fileNotExist', 'dest');
    }
    
    public function testCopyFileWithSuccess()
    {
    	$this->mock('isFileExists', true);
    	$this->mock('copy');
    	$this->assertInstanceOfService($this->s()->copyFile('source', 'destination'));
    	$this->assertEquals(array('source', 'destination'), $this->m()->getCallArgs('copy'));
    }
    
    /**
     * copyContentDir
     */
    public function testCopyContentDirWithSuccess()
    {
    	$this->mock('scandir',array('.', '..', 'ceSousDossier'));
    	$this->mock('is_dir',true);
    	$this->mock('scandir',array('.', '..', 'ceFichier'));
    	$this->mock('is_dir',false);
    	$this->mock('copy');
    	$this->mock('mkdir');
    	$actual = $this->s()->copyContentDir('ceDossier', 'versCeDossier');
    	$this->assertInstanceOfService($actual);
    	$this->assertEquals(1, $this->m()->countCalls('mkdir'));
    	$this->assertEquals(array('ceDossier/ceSousDossier/ceFichier', 'versCeDossier/ceSousDossier/ceFichier'), 
    						$this->m()->getCallArgs('copy'));
    	$this->assertEquals(array('versCeDossier/ceSousDossier'), $this->m()->getCallArgs('mkdir'));
    }
    
    /**
     * deleteDir
     */
    public function testDeleteDirWithSuccess()
    {
        $this->mock('isFileExists',true);
        $this->mock('scandir',array('.', '..', 'ceSousDossier'));
    	$this->mock('is_dir',true);
        $this->mock('isFileExists',true);
        $this->mock('scandir',array('.', '..', 'ceFichier'));
    	$this->mock('is_dir',false);
    	$this->mock('is_deletable', true);
    	$this->mock('unlink');
    	$this->mock('rmdir');
    	$this->mock('rmdir');
    	$actual = $this->s()->deleteDir('ceDossier');
    	$this->assertInstanceOfService($actual);
    	$this->assertEquals(2, $this->m()->countCalls('rmdir'));
    	$this->assertEquals(array('ceDossier/ceSousDossier/ceFichier'), $this->m()->getCallArgs('unlink'));
    	$this->assertEquals(array('ceDossier/ceSousDossier'), $this->m()->getCallArgs('rmdir', 0));
    	$this->assertEquals(array('ceDossier'), $this->m()->getCallArgs('rmdir', 1));
    }
    
    /**
     * deleteFile
     */
    public function testDeleteFileWithNotDeletableFileThrowException()
    {
    	$this->mock('is_deletable', false);
    	$this->setExpectedException('RuntimeException', "le fichier 'fichierNotDeletable' ne peut être supprimé car vous n'avez pas les droits ou le fichier est ouvert");
    	$actual = $this->s()->deleteFile('fichierNotDeletable');
    }
    
    /**
     * cleanDir
     *
     */
    public function testCleanDirWithNotDeletableFileThrowException()
    {
        $this->mock('isFileExists',true);
        $this->mock('scandir',array('.', '..', 'ceSousDossier'));
    	$this->mock('is_dir',true);
        $this->mock('isFileExists',true);
        $this->mock('scandir',array('.', '..', 'fichierNotDeletable'));
    	$this->mock('is_dir',false);
    	$this->mock('is_deletable', false);
        $this->mock('unlink');
    	$this->mock('rmdir');
    	$this->setExpectedException('RuntimeException', "le fichier 'ceDossier/ceSousDossier/fichierNotDeletable' ne peut être supprimé car vous n'avez pas les droits ou le fichier est ouvert");
    	$actual = $this->s()->cleanDir('ceDossier');
    }
    
    public function testCleanDirWithSuccess()
    {
        $this->mock('isFileExists',true);
        $this->mock('scandir',array('.', '..', 'ceSousDossier'));
    	$this->mock('is_dir',true);
        $this->mock('isFileExists',true);
        $this->mock('scandir',array('.', '..', 'ceFichier'));
    	$this->mock('is_dir',false);
    	$this->mock('is_deletable', true);
    	$this->mock('unlink');
    	$this->mock('rmdir');
    	$actual = $this->s()->cleanDir('ceDossier');
    	$this->assertInstanceOfService($actual);
    	$this->assertEquals(1, $this->m()->countCalls('rmdir'));
    	$this->assertEquals(array('ceDossier/ceSousDossier/ceFichier'), $this->m()->getCallArgs('unlink'));
    	$this->assertEquals(array('ceDossier/ceSousDossier'), $this->m()->getCallArgs('rmdir'));
    }

    /**
     * getMimeType
     */
   public function testGetMimeTypeWithUnknownMimetypeThrowRuntimeException()
   {
		$this->setExpectedException('RuntimeException', "le mime type pour le fichier 'unknownMimeFile.ko' est inconnu");
		$this->s()->getMimeType('unknownMimeFile.ko');
   }
   
   public function testGetMimeTypeWithSuccess()
   {
   		$this->assertEquals('application/vnd.ms-excel', $this->s()->getMimeType('unfichierExcel.xls'));		
   }
}