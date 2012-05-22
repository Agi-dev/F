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
    public function isConnected();

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
     * @param string $sql script sql
     *
     * @return bool
     */
    public function executeDirectQuery($sql);

    /**
     * Recupère la date du jour au format de la base de données
     *
     * @return string
     */
    public function getDbDateToday();

    /**
     * Connecte la base de données
     *
     * @param array $config
     *
     * @return \F\Technical\Database\Adapter\Definition
     */
    public function connect($config);

    /**
     * Récupère la configuration nécessaire à la connection
     *
     * @return array
     */
    public function getConnectConfig();

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