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
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
class TechnicalExcelInteTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Excel\Service
     */
    public function s()
    {
        return parent::s();
    }

	/**
	 * open
	 */
	public function testOpenWithFileNotFoundThrowException()
    {
		$this->setExpectedException('RuntimeException', "le fichier 'notExist' n'existe pas");
		$this->s()->open('notExist');   	
    }
    
    public function testOpenExcel5WithSuccess()
    {
    	$actual = $this->s()->open($this->getDataSetPath().'/Excel5File.xls');
    	$this->assertInstanceOfService($actual);
    }
    
    public function testOpenExcel2007WithSuccess()
    {
    	$actual = $this->s()->open($this->getDataSetPath().'/Excel2007File.xlsx');
    	$this->assertInstanceOfService($actual);
    }
    
    /**
     * toArray
     */
    public function testToArrayWithExcel5AlreadyOpenSuccess()
    {
    	$this->s()->open($this->getDataSetPath().'/Excel5File.xls');
    	$actual = $this->s()->toArray();
    	$this->assertEqualsResultSet($actual);
    }
    
    public function testToArrayWithExcel2007Success()
    {
    	$actual = $this->s()->toArray($this->getDataSetPath().'/Excel2007File.xlsx');
    	$this->assertEqualsResultSet($actual);
    }
    
    public function testToArrayWithInfectedColumnDataSuccess()
    {
    	$actual = $this->s()->toArray($this->getDataSetPath().'/InfectedColumn.xlsx');
    	$this->assertEqualsResultSet($actual);
    }
    
    public function testToArrayWithInfectedRowDataSuccess()
    {
    	$actual = $this->s()->toArray($this->getDataSetPath().'/InfectedRow.xlsx');
    	$this->assertEqualsResultSet($actual);
    }
    
    /**
     * arrayToExcel
     */
    public function testArrayToExcelIntoExcel2007WithSuccess()
    {
    	$this->cleanFolderInDataset('excel');
    	$data = array(
    			array('some data','data bis'),
    			array('other data', ''),
    	);
    	$filename = $this->getDataSetPath().'/excel/testArrayToExcelWithSuccess.xlsx';
    	$this->s()->arrayToExcel($filename, $data);
    	$this->assertFileExists($filename);
    	$actual = $this->s()->toArray($filename);
    	$this->assertEquals($data, $actual);
    }
    
    public function testArrayToExcelIntoExcel5WithSuccess()
    {
    	$this->cleanFolderInDataset('excel');
    	$data = array(
    			array('some data','data bis'),
    			array('other data', ''),
    	);
    	$filename = $this->getDataSetPath().'/excel/testArrayToExcelWithSuccess.xls';
    	$this->s()->arrayToExcel($filename, $data, 'Excel5');
    	$this->assertFileExists($filename);
    	$actual = $this->s()->toArray($filename);
    	$this->assertEquals($data, $actual);
    }
}