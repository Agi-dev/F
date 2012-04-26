<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Database\Adapter\Definition
 * is the adapter interface for the database service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Pascal Renaut <prenaut.ext@orange.com>
 * @package    F\Technical\Database\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Database\Adapter;

/**
 * F\Technical\Database\Adapter\Definition
 * is the adapter interface for the database service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Database\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
    /**
     * Récupére le resultat d'une requete
     * 
     * @param \Zend_Db_Adapter $cnx handler de connection 
     * @param string $sql
     * @param array $sqlParams
     * 
     * @return array 
     */
    public function fetchAll($cnx, $sql, $sqlParams);
    
    /**
     * Vérifie si on est connecté à la base
     * 
     * @param $cnx handler de connection
     * 
     * @return boolean
     */
    public function isConnected($cnx);
    
    /**
     * Récupère la connection courante
     * 
     * @return \Zend_Db_Adapter_Abstract
     */
    public function getConnection();
    
    /**
     * Lit le contenu d'un fichier
     * 
     * @param string $filename
     * 
     * @return string
     * 
     * @throw RuntimeException
     */
    public function getFileContent($filename);
    
    /**
     * Execute un script sql
     * 
     * @param mixed $cnx handler bdd
     * @param string $sql script sql
     * 
     * @return 
     */
    public function executeDirectQuery($cnx, $sql);
    
    /**
     * Récupère la config de la connection à la basse de données
     * 
     * @param mixed $cnx hnadler bdd
     * 
     * @return array
     */
    public function getDbConfig($cnx);
    
    /**
     * Recupère la date du jour au format de la base de données
     *
     * @return string
     */
    public function getDbDateToday();
    
    /**
     * Récupère un objet db table
     * 
     * @param string $tablename
     * 
     * @return \Zend_Db_Table_Abstract
     */
    public function getDbTableObject($tablename);
    
    /**
     * Insert en base de données
     * 
     * @param \Zend_Db_Table_Abstract $dbtable
     * @param array $data
     * 
     * @return ?
     */
    public function insert($dbtable, $data);
    
    /**
     * Récupère l'identifiant de la dernière insertion
     * 
     * @param \Zend_Db_Table_Abstract $dbtable
     * 
     * @return mixed
     */
    public function lastInsertId($dbtable);
    
    /**
     * Connecte la base de données
     * 
     * @param \Zend_db_Adapter_Abstract $cnx
     * 
     * @return \F\Technical\Database\Adapter\Definition
     */
    public function connect($cnx);
    
    /**
     * Récupère la clef primaire de tablename
     * 
     * @param \Zend_Db_Table_Abstract $dbtable
     * 
     * @return mixed
     */
    public function getIdColumn($dbtable);
    
    /**
     * Commence une transaction
     * 
     * @param \Zend_db_Adapter_Abstract $cnx
     * 
     * @return void
     */
    public function beginTransaction($cnx);
    
    /**
     * Annule une transaction
     *
     * @param \Zend_db_Adapter_Abstract $cnx
     * 
     * @return void
     */
    public function rollbackTransaction($cnx);
    
    /**
     * Valide une transaction
     *
     * @param \Zend_db_Adapter_Abstract $cnx
     *
     * @return void
     */
    public function commitTransaction($cnx);
    
}
// @codeCoverageIgnoreEnd