<?php
/**
 * F\Technical\Database\Service is a class to handle database operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Pascal Renaut <prenaut.ext@orange.com>
 * @package   F\Technical\Database
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Database;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Database\Service is a class to handle database operations.
 *
 * @category F
 * @package F\Technical\Database
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
    /**
     * Current Transaction Level
     *
     * @var int
     */
    protected $_transactionLevel = 0;
    
    /**
     * handle de connection
     * @var mixed
     */
    protected $_cnx = null;
    
	/**
	 * Returns the singleton of this service
	 *
	 * @return F\Technical\Database\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Database\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Database\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
    /**
     * Retourne le resultat d'une requete
     * 
     * @param string $sql
     * @param array $tab
     */
	public function fetchAll($sql, $sqlParams)
	{
	    return $this->getAdapter()->fetchAll($this->getConnection(), $sql, $sqlParams);
	}
	
	/**
	 * Récupère la clef primaire d'une classe
	 * 
	 * @param unknown_type $tablename
	 * 
	 * @return mixed
	 */
	public function getIdColumn($tablename)
	{
	    $dbtable = $this->getAdapter()->getDbTableObject($tablename);
	    return $this->getAdapter()->getIdColumn($dbtable);
	}
	
	/**
	 * Exec script file
	 *
	 * @param string $filename
	 *
	 * @return \F\Technical\Database\Service
	 */
	public function execScriptFile($filename)
	{
		$cnx = $this->getConnection();
		$contents = $this->getAdapter()->getFileContent($filename);
	
	
		// Remove C style and inline comments
		$comment_patterns = array(
				'/^\s*--.*/m', //inline comments start with --
				'/^\s*#.*/m', //inline comments start with #
		);
	
		$contents = preg_replace($comment_patterns, "\n", $contents);
	
		// Change crlf to lf
		$contents = preg_replace("/\r\n/", "\n", $contents);
	
		//Retrieve sql statements
		$statements = explode(";\n", $contents);
		$statements = preg_replace("/\s/", ' ', $statements);
	
		foreach ($statements as $query) {
			$query = trim($query);
			if ('' !== $query ) {
				$res = $this->getAdapter()->executeDirectQuery($cnx, $query);
			}
		}
		return $this;
	}
	
	
    /**
	 * Récupère la connection Connection
	 *
	 * @return mixed
	 *
	 * @throw RuntimeException si pas connecté
	 */
	public function getConnection()
	{
		if ( null === $this->_cnx ) {
    	    $this->_cnx = $this->checkConnection()
    		            ->getAdapter()->getConnection();
		}
		return $this->_cnx;
	}
	
	/**
	 * Connecte la base de données
	 * 
	 * @return \F\Technical\Database\Service
	 */
	public function connect()
	{
	    $this->getAdapter()->connect($this->getAdapter()->getConnection());
	    return $this;
	}
	
	
	
	/**
	 * Check if there is a ddb connection
	 *
	 * @return $this
	 *
	 * @throw RuntimeException
	 */
	public function checkConnection()
	{
		if ( false === $this->isConnected() ) {
			$this->throwException('database.notconnected');
		}
		return $this;
	}
	
	/**
	 * Teste la connection à la bdd
	 *
	 * @return boolean
	 */
	public function isConnected()
	{
	     return $this->getAdapter()->isConnected($this->getAdapter()->getConnection());
	}
	
	/**
	 * Récupère le configuration courante de la base de données
	 */
	public function getConfig()
	{
	    return $this->getAdapter()->getDbConfig($this->getConnection());
	}
	
	/**
	 * Recupère la date du jour au format de la base de données
	 * 
	 * @return string 
	 */
	public function getDbDateToday()
	{
	    return $this->getAdapter()->getDbDateToday();
	}

	//PR
	/**
	 * Recupère le nom de la table de la base de données
	 *
	 * @return string
	 */
	public function getDbTableObject()
	{
		return $this->getAdapter()->getDbTableObject();
	}	
	
	/**
	 * Insert les donnnées dans la table
	 * 
	 * @param array $data données (champs => valeur)
	 * @param string $tablename nom de la table
	 * @param string $module nom du module (null par défaut)
	 * 
	 * @return id
	 */
	public function insert($data, $tablename, $module = null)
	{
	    
	    $this->checkConnection();
	    $dbtable = $this->getAdapter()->getDbTableObject($tablename, $module);

	    return $this->getAdapter()->insert($dbtable, $data);

	    //return $this->getAdapter()->lastInsertId($dbtable); 
	    
	}
	
	/**
	 * Commence une transaction
	 * 
	 * @return \F\Technical\Database\Service
	 */
	public function beginTransaction()
	{
	    if ( $this->_transactionLevel === 0 ) {
	    	$this->getAdapter()->beginTransaction($this->getConnection());
	    }
	    $this->_transactionLevel++;
	    
	    return $this;
	}
	
	/**
	 * Annule une transaction
	 * 
	 * @return \F\Technical\Database\Service
	 */
	public function rollbackTransaction()
	{
	    if ( $this->_transactionLevel === 1 ) {
	    	$this->getAdapter()->rollbackTransaction($this->getConnection());
	    }
	    return $this->_transactionLevelDecrement();
	}
	
	/**
	 * Valide une transaction
	 * 
	 * @return \F\Technical\Database\Service
	 */
	public function commitTransaction()
	{
	    if ( $this->_transactionLevel === 1 ) {
	    	$this->getAdapter()->commitTransaction($this->getConnection());
	    }
	    	    
	    return $this->_transactionLevelDecrement();
	}
	
	/**
	 * Decremente le niveau de transaction
	 * 
	 */
	protected function _transactionLevelDecrement()
	{
	    if (0 < $this->_transactionLevel ) {
	        $this->_transactionLevel--;
	    }
	    return $this;
	}
	
	/**
	 * Retourne le niveau de transaction
	 */
	public function getTransactionLevel()
	{
	    return $this->_transactionLevel;
	}
}