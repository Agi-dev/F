<?php
/**
 * F\Technical\Excel\Service is
 * a class to handle excel operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package    F\Technical\Excel\Adapter
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Excel;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Excel\Service is
 * a class to handle excel operations.
 *
 * @category F
 * @package F\Technical\Excel
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class TechnicalExcelUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Excel\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Excel\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}
	
	/**
	 * open
	 */
	public function testOpenWithFileNotFoundThrowException()
    {
		$this->mock('checkFileExists', new \RuntimeException("le fichier 'notExist' n'existe pas"));
    	$this->setExpectedException('RuntimeException', "le fichier 'notExist' n'existe pas");
		$this->s()->open('notExist');   	
    }
    
    public function testOpenWithSuccess()
    {
    	$this->mock('checkFileExists');
    	$this->mock('open');
    	$actual = $this->s()->open('fileExist');
    	$this->assertInstanceOfService($actual);
    }
    
    /**
     * checkExcelOpen
     */
    public function testCheckExcelOpenWithNoExcelOpenThrowException()
    {
    	$this->mock('isExcelOpen', false);
    	$this->setExpectedException('RuntimeException', "la ressource excel est null ou incorrect");
    	$this->s()->checkExcelOpen();
    }
    
    public function testCheckExcelOpenWithSuccess()
    {
    	$this->mock('isExcelOpen', true);
    	$this->assertInstanceOfService($this->s()->checkExcelOpen());
    }

    /**
     * toArray
     */
	public function testToArrayWithAlreadyExcelOpenWithSuccess()
    {
    	$this->mock('isExcelOpen', true);
    	$this->mock('toArray', 'un tableau');
    	$actual = $this->s()->toArray();
    	$this->assertEquals('un tableau', $actual);
    }
    
    public function testToArrayWithFilenameToOpenWithSuccess()
    {
    	$this->mock('checkFileExists');
    	$this->mock('open');
    	$this->mock('toArray', 'un tableau');
    	$actual = $this->s()->toArray('un excel');
    	$this->assertEquals('un tableau', $actual);
    }
    
    /**
     * arrayToExcel
     */
    public function testArrayToExcelWithNoExcelTypeSpecifiedSuccess()
    {
    	$data = array(
    			array('some data','data bis'),
    			array('other data'),
    	);
    	$this->mock('getFileExtension', 'xlsx');
    	$this->mock('create');
    	$this->mock('setCellValue');
    	$this->mock('setCellValue');
    	$this->mock('setCellValue');
    	$this->mock('save');
    	$this->assertInstanceOfService($this->s()->arrayToExcel('fichier.xlsx', $data));
    	$this->assertEquals(array('A1', 'some data'),$this->m()->getCallArgs('setCellValue', 0));
    	$this->assertEquals(array('B1', 'data bis'),$this->m()->getCallArgs('setCellValue', 1));
    	$this->assertEquals(array('A2', 'other data'),$this->m()->getCallArgs('setCellValue', 2));
    }
    
    /**
     * getColNameFromNumber
     */
    public function testGetColNameFromNumber()
    {
    	$this->assertEquals('A', $this->s()->getColNameFromNumber(0));
    	$this->assertEquals('Z', $this->s()->getColNameFromNumber(25));
    	$this->assertEquals('AC', $this->s()->getColNameFromNumber(28));
    	$this->assertEquals('UMX', $this->s()->getColNameFromNumber(14557));
    }
    
    /**
     * getExcelType
     */
    public function testGetExcelTypeWithBadExcelThrowException()
    {
    	$message = "le fichier 'badExcel' n'est pas un fichier excel";
    	$this->mock('getFileExtension', new \RuntimeException($message));
    	$this->setExpectedException('RuntimeException', $message);
    	$this->s()->getExcelType('badExcel');	
    }
    
    public function testGetExcelTypeWithSuccess()
    {
    	$this->mock('getFileExtension', 'xlsx');
    	$this->mock('getFileExtension', 'xls');
    	$this->assertEquals('Excel2007', $this->s()->getExcelType('excel2007.xlsx'));
    	$this->assertEquals('Excel5', $this->s()->getExcelType('excel5.xls'));
    }
}