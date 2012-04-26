<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Base\Table\Adapter\Definition
 * is the adapter interface for the i18n service.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François Schneider <fschneider.ext@orange.com>
 * @package    F\Technical\Base\Table\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Table\Adapter;

/**
 * F\Technical\Base\Table\Adapter\Definition
 * is the adapter interface for the i18n service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Technical\Base\Table\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
    /**
     * Insert en base de données
     * 
     * @param unknown_type $data
     * @param unknown_type $tablename
     * 
     * @return mixed id
     */
    public function insert($data, $tablename);
    
    /**
     * Récupére le cuid de l'utilisateur courant
     * 
     * @return string
     */
    public function getCuidUserConnected();
    /**
     * Récupère le type d'historique creation
     * 
     * @return string
     */
    public function getHistoryCreateType();
    /**
     * Récupère le type d'historique suppression
     * 
     * @return string
     */
    public function getHistoryDeleteType();
    /**
     * Récupère le type d'historique modification
     * 
     * @return string
     */
    public function getHistoryUpdateType();
    
    /**
     * Sauvegarde la maj dans l'historique
     * 
     * @param string $tablename
     * @param string $cuid
     * @param string $id
     * @param string $type
     * @param string $new
     * @param string $old
     * 
     * @return ?
     */
    public function saveHistory($tablename, $cuid, $id, $type, $new, $old = null);
    
    /**
     * Récupère la clef primaire de la table
     * 
     * @param string $tablename nom de la table
     * 
     * @return string
     */
    public function getIdColumn($tablename);
    
    /**
     * Récupére le resultat d'une requete
     * @param string $sql
     * @param array $sqlParams
     * 
     * @return array
     */
     public function fetchAll($sql, $sqlParams = array());
     
     /**
      * Commence une transaction
      *
      * @return void
      */
     public function beginTransaction();
     
     /**
      * Annule une transaction
      *
      * @return void
      */
     public function rollbackTransaction();
     
     /**
      * Valide une transaction
      *
      * @return void
      */
     public function commitTransaction();
}
// @codeCoverageIgnoreEnd