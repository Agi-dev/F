<?php
/**
 * F\Technical\Image\Service is
 * a class to handle image operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package    F\Technical\Image\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Image;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Image\Service is
 * a class to handle image operations.
 *
 * @category F
 * @package F\Technical\Image
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class TechnicalImageUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Image\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Image\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * isJpeg
     */
	public function testIsJpegWithFileNotExistsThrowRuntimeException()
    {
    	$message = "le fichier 'fileNotExists' n'existe pas";
    	$this->mock('checkFileExists', new \RuntimeException($message));
    	$this->setExpectedException('RuntimeException', $message);
    	$this->s()->isJpeg('fileNotExists');
    }
	
	public function testIsJpegWithNoJpegReturnFalse()
    {
    	$this->mock('checkFileExists');
    	$this->mock('isJpeg', false);
    	$this->assertFalse($this->s()->isJpeg('notJpg'));
    }
    
    public function testIsJpegWithJpegReturnTrue()
    {
    	$this->mock('checkFileExists');
    	$this->mock('isJpeg', true);
    	$this->assertTrue($this->s()->isJpeg('Jpg'));
    }
    
    /**
     * getSize
     */
    public function testGetSizeWithFileNotExistsThrowRuntimeException()
    {
    	$message = "le fichier 'fileNotExists' n'existe pas";
    	$this->mock('checkFileExists', new \RuntimeException($message));
    	$this->setExpectedException('RuntimeException', $message);
    	$this->s()->getSize('fileNotExists');
    }
    
    public function testGetSizeWithSuccess()
    {
    	$this->mock('checkFileExists');
    	$this->mock('getSize', 1000);
    	$this->assertEquals(1000, $this->s()->getSize('une image'));
    }
    
    /**
     * resizeByHeight
     */
    public function testResizeByHeightWithFileNotExistsThrowRuntimeException()
    {
    	$message = "le fichier 'imageNotExists' n'existe pas";
    	$this->mock('checkFileExists', new \RuntimeException($message));
    	$this->setExpectedException('RuntimeException', $message);
    	$this->s()->resizeByHeight('imageNotExists', 100);
    }
    
    public function testResizeByHeightWithSuccess()
    {
    	$filename = 'imageExists';
    	$width = 300;
    	$height= 200;
    	$newWidth = 150;
    	$newHeight = 100;
    	
    	$this->mock('checkFileExists');
    	$this->mock('getDimension', array($width, $height));
    	$this->mock('resize', 'une resource');
    	$this->mock('deleteFile');
    	$this->mock('saveJpeg');
    	
    	$this->assertInstanceOfService($this->s()->resizeByHeight($filename, $newHeight));
    	$this->assertEquals(array($filename, $newWidth, $newHeight, $width, $height), $this->m()->getCallArgs('resize'));
    }
}