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
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
class TechnicalImageInteTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Image\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * isJpeg
     */
	public function testIsJpegWithNoJpegReturnFalse()
    {
    	$this->assertFalse($this->s()->isJpeg($this->getDataSetPath() . '/mire.bmp'));
    }
    
    public function testIsJpegWithJpegReturnTrue()
    {
    	$this->assertTrue($this->s()->isJpeg($this->getDataSetPath() . '/mire.jpg'));
    }
    
    /**
     * getSize
     */
    public function testGetSizeWithSuccess()
    {
    	$this->assertEquals(900, $this->s()->getSize($this->getDataSetPath() . '/mire.bmp'));
    }
    
    /**
     * resizeByHeight
     */
    public function testResizeByHeightWithFileNotExistsThrowRuntimeException()
    {
    	$message = "le fichier 'imageNotExists' n'existe pas";
    	$this->setExpectedException('RuntimeException', $message);
    	$this->s()->resizeByHeight('imageNotExists', 100);
    }
    
    public function testResizeByHeightWithSuccess()
    {
    	$p = $this->getDataSetPath();
    	$this->cleanFolderInDataset('image');
    	
    	$filename = $p . '/image/mire.jpg';
    	$newHeight = 300;
    	
    	// pour éviter d'écraser l'original, on copie l'image dans le rertoire image
    	copy($p . '/mire.jpg', $filename);
    	$this->assertInstanceOfService($this->s()->resizeByHeight($filename, $newHeight));
    	$this->assertFileExists($filename);
    	list($width, $height) = $this->s()->getDimension($filename);
    	$this->assertEquals($width, 400);
    	$this->assertEquals($height, 300);
    }
}
