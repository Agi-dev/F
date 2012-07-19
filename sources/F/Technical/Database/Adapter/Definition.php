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
     * @param string $sql
     *
     * @return array
     */
    public function fetchAll($sql);

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

    /**
     * Include queries file
     *
     * @param string $file
     *
     * @return array
     */
    public function includeQueriesFile($file);

    /**
     * init queries file directory
     *
     * @params string $path
     *
     * @return \F\Technical\Database\Adapter\Definition
     */
    public function setQueriesPath($path);

    /**
     * check if dir exist
     *
     * @param $path
     *
     * @return \F\Technical\Database\Adapter\Definition
     *
     * @throw RuntimeException filesystem.dir.notfound
     */
    public function checkDirExists($path);

    /**
     * Gets the last ID generated automatically by an IDENTITY/AUTOINCREMENT column.
     *
     * @param string $tablename
     *
     * @return int
     */
    public function getLastInsertId($tablename);
}
// @codeCoverageIgnoreEnd