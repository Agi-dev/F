<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Excel\Adapter\Native is
 * the native adapter for the excel service,
 * that implements PHP natives primitives.
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

namespace F\Technical\Excel\Adapter;

/**
 * @see F/Technical/Excel/Adapter/Definition.php
 */
require_once 'F/Technical/Excel/Adapter/Definition.php';

/**
 * @see F/Technical/Filesystem/Service.php
 */
require_once 'F/Technical/Filesystem/Service.php';

/**
 * @see PHPExcel/IOFactory.php
 */
require_once 'PHPExcel/IOFactory.php';

/**
 * F\Technical\Excel\Adapter\Native is the native adapter
 * for the excel service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Excel\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
	/**
	 * resource excel
	 * @var  \PHPExcel
	 */
	protected $_excel = null;
	
	/**
	 * page courante
	 * @var PHPExcel_Worksheet
	 */
	protected $_sheet = null;
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::checkFileExists()
	 */
	public function checkFileExists ($filename)
	{
		\F\Technical\Filesystem\Service::singleton()->checkFileExists($filename);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::open()
	 */
	public function open ($filename)
	{
		$this->_excel = \PHPExcel_IOFactory::load($filename);
		$this->_sheet = $this->_excel->getActiveSheet();
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::checkExcelIsOpen()
	 */
	public function isExcelOpen()
	{
		return (null !== $this->_excel);	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::toArray()
	 */
	public function toArray()
	{
		return $this->_sheet->toArray(false, true,true);	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::getFileExtension()
	 */
	public function getFileExtension($filename)
	{
		return \F\Technical\Filesystem\Service::singleton()->getFileExtension($filename);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::create()
	 */
	public function create()
	{
		$this->_excel = new \PHPExcel();
		$this->_sheet = $this->_excel->setActiveSheetIndex(0);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::setCellValue()
	 */
	public function setCellValue ($cellNum, $value)
	{
		$this->_sheet->setCellValue($cellNum, $value);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \F\Technical\Excel\Adapter\Definition::save()
	 */
	public function save($filename, $type)
	{
		$w = \PHPExcel_IOFactory::createWriter($this->_excel, $type);
		$w->save($filename);
		return $this;
	}
}
// @codeCoverageIgnoreEnd