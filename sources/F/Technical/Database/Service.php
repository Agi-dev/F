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
     * @param array $params
     *
     * @return array result
     */
	public function fetchAll($sql, $params = array())
	{
	    $this->checkConnection();
	    $sql = $this->prepare($sql, $params);
	    return $this->getAdapter()->fetchAll($sql);
	}

	/**
	 * Quotes a value and places into a piece of text at a placeholder.
     *
     * The placeholder is a question-mark; all placeholders will be replaced
     * with the quoted value.   For example:
	 *
	 * <code>
     * $text = "WHERE date < ?";
     * $date = "2005-01-02";
     * $safe = $sql->quoteInto($text, $date);
     * // $safe = "WHERE date < '2005-01-02'"
     * </code>
     *
	 * @param string $sql
	 * @param mixed $params
	 *
	 * @return string sql
	 */
	public function prepare($sql, $params = array() )
	{
		if (null !== $params && false === is_array($params) ) {
            $params = array( $params );
        }
        if ( true === empty($params) ) {
        	return $sql;
        }
        return $sql;

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
		$this->checkConnection();
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
				$res = $this->getAdapter()->executeDirectQuery($query);
			}
		}
		return $this;
	}

	/**
	 * Connecte la base de données
	 *
	 * $config = array(
     *       'host'     => '127.0.0.1',
     *       'username' => 'webuser',
     *       'password' => 'xxxxxxxx',
     *       'name'     => 'test'
     * )
	 *
	 * @param array config
	 *
	 * @return \F\Technical\Database\Service
	 */
	public function connect($config=null)
	{
		if (null === $config) {
            $config = $this->getAdapter()->getConnectConfig();
        }
        $this->getAdapter()->connect($config);
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
	     return $this->getAdapter()->isConnected();
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

	/**
	 * Commence une transaction
	 *
	 * @return \F\Technical\Database\Service
	 */
	public function beginTransaction()
	{
	    if ( $this->_transactionLevel === 0 ) {
	    	$this->getAdapter()->beginTransaction();
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
	    	$this->getAdapter()->rollbackTransaction();
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
	    	$this->getAdapter()->commitTransaction();
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