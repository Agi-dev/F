<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Excel\Adapter\Definition
 * is the adapter interface for the excel service.
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
 * F\Technical\Excel\Adapter\Definition
 * is the adapter interface for the excel service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Excel\Adapter
 * @copyright  Copyright (c) 2013 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	/**
     * Vérifie que le fichier existe
     *
     * @param string $filename
     * 
     * @throw RuntimeException if not exists
     * @return F\Technical\Excel\Adapter\Definition
     */
    public function checkFileExists($filename);
    
    /**
     * Ouvre le fichier excel
     * 
     * @param string $filename
     * 
     * @return F\Technical\Excel\Adapter\Definition
     */
    public function open($filename);
    
    /**
     * Vérifie qu'un document est déjà ouvert
     * 
     * @throw RuntimeException if not exists
     * @return bool
     */
    public function isExcelOpen();
    
    /**
     * charge le document en cours dans un tableau
     * 
     * @return array
     */
    public function toArray();
    
     /**
     * récupère l'extension du fichier
     * 
     * @param string $filename
     * 
     * @return string
     */
    public function getFileExtension($filename);
    
    /**
     * create excel resource
     * 
     * @return F\Technical\Excel\Adapter\Definition
     */
    public function create();
    
    /**
     * ecris une valeur dans la cellule
     *
     * @param string $cellNum
     * @param mixed $value
     *
     * @return F\Technical\Excel\Adapter\Definition
     */
   	public function setCellValue ($cellNum, $value);
   	
   	/**
   	 * Sauvegarde le document excel
   	 *
   	 * @param string $filename
   	 * @param string $type ( Excel2007 | Excel5 )
   	 *
   	 * @throw Exception
   	 * @return F\Technical\Excel\Adapter\Definition
   	 */
    public function save($filename, $type);
}
// @codeCoverageIgnoreEnd