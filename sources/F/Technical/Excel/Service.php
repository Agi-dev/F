<?php
/**
 * F\Technical\Excel\Service is a class to handle excel operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <fschneider@astek.fr>
 * @package   F\Technical\Excel
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Excel;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Excel\Service is a class to handle excel operations.
 *
 * @category F
 * @package F\Technical\Excel
 * @copyright Copyright (c) 2013 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
	/**
	 * Returns the singleton of this service
	 *
	 * @return \F\Technical\Excel\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Technical\Excel\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Technical\Excel\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
	
	/**
	 * open Excel file
	 * @param string $filename
	 * @return $this
	 */
	public function open($filename)
	{
		$this->getAdapter()->checkFileExists($filename);
		$this->getAdapter()->open($filename);
		return $this;
	}
	
	/**
	 * 
	 * @param string $filename
	 */
	public function toArray($filename=null)
	{
		// ouvre le fichier excel si necessaire
		if ( null !== $filename ) {
			$this->open($filename);
		}
		else {
			$this->checkExcelOpen();
		}
		// lit le fichier excel
		$data = $this->getAdapter()->toArray();
		
		
		// on supprime les column false
		if(is_array($data)){
			$toDelete = array();
			foreach($data as $key =>$donnee) {							
				foreach($donnee as $clef =>$valeur) {
					if(!isset($toDelete[$clef])){
						$toDelete[$clef] = true;
					}
					if(false !== $valeur && "" !== $valeur){
						$toDelete[$clef] = false;
					} 		
				}
			}
			for($i=count($toDelete);$i > 0;$i--){
				if($toDelete[$i-1]){
					foreach($data as $key =>$donnee) {
						unset($data[$key][$i-1]);
					}					
				}
			}
				
		}
		// on supprime les row false 
		if(is_array($data)){
			$toDelete = array();
			foreach($data as $key =>$donnee) {
				$delete = true;
				foreach($donnee as $clef =>$valeur) {
					if($valeur && ( false !== $valeur || "" !== $valeur)){
						$delete = false;
						break;
					}
				}
				if($delete){
					$toDelete[] = $key;
				}
			}
			foreach($toDelete as $sup) {
				array_splice($data,$sup);
			}
			
		}
		return $data;
	}
	
	/**
	 * Vérifie si un excel est chargé
	 * @return \F\Technical\Excel\Service
	 */
	public function checkExcelOpen()
	{
		if ( false === $this->getAdapter()->isExcelOpen() ) {
			$this->throwException('excel.resource.badformat');
		}
		return $this;		
	}
	
	/**
	 * convert an array into excel
	 * 
	 * @param string $filename
	 * @param array $data
	 * @param string $type
	 * 
	 * @return \F\Technical\Excel\Service
	 */
	public function arrayToExcel($filename, $data, $type = null)
	{
		// si pas de type on le recupère
		if ( null === $type ) {
			$type = $this->getExcelType($filename);
		}
		
		// On crée un resource Excel
		$this->getAdapter()->create();
		
		// Pour chaque ligne, on ajoute les colonnes
		foreach ($data as $r => $row) {
			foreach ($row as $c => $col) {
				$cellNum = $this->getColNameFromNumber($c) . ($r+1);
				$this->getAdapter()->setCellValue($cellNum, $col);
			}
		}
		
		$this->getAdapter()->save($filename, $type);
		
		return $this;
	}
	
	/**
	 * Converti un numérique un numéro de colonne Excel equivalent
	 * ex : 0 => A
	 * 		1 => B
	 * 		26 => AA
 	 * 		27 => AB
	 * 		14557 => UMX
	 * 
	 * @param int $num
	 * 
	 * @return string
	 */
	public function getColNameFromNumber($num)
	{
		$numeric = $num % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval($num / 26);
		if ($num2 > 0) {
			return $this->getColNameFromNumber($num2 - 1) . $letter;
		} else {
			return $letter;
		}
	}
	
	/**
	 * Récupère le type de fichier excel
	 * @param string $filename
	 * @return string 'Excel2007' si fichier excel 2007
	 * 				  'Excel5'    si fichier excel 97-2003
	 */
	public function getExcelType($filename)
	{
		// récupère l'extension du fichier excel
		$ext = $this->getAdapter()->getFileExtension($filename);
		
		$extensionType = NULL;
		switch (strtolower($ext)) {
			case 'xlsx':			//	Excel (OfficeOpenXML) Spreadsheet
				$extensionType = 'Excel2007';
				break;
			case 'xls':				//	Excel (BIFF) Spreadsheet
				$extensionType = 'Excel5';
				break;
			default:
				$this->throwException('excel.badformat', $filename);
				break;
		}
		
		return $extensionType;
	}
}