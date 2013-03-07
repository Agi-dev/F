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
     * Récupére le resultat d'une requete
     *
     * @param string $key
     * @param array $sqlParams
     *
     * @return array
     */
     public function fetchAll($key, $sqlParams = array());
     
     /**
      * Insert les donnnées dans la table
      *
      * @param string $tablename nom de la table
      * @param array $data données array('field' => 'value')
      *
      * @return id
      */
     public function insert($data, $tablename);

    /**
     * Update
     *
     * @param array $data
     * @param string $tablename
     *
     * @return int nb u
     */
    public function update($data, $where, $tablename);
    
    /**
     * Delete les données en fonction de la clause where
     *
     * @param mixed $where
     * @param string $tablename
     *
     * @return nb delete
     */
    public function delete($where=null, $tablename);

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