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
	 * @return \F\Technical\Database\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return \F\Technical\Database\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Technical\Database\Adapter\Definition
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
	    f_trace('database.fetchall.query', $sql);
	    return $this->getAdapter()->fetchAll($sql);
	}

	/**
     * Retourne le resultat d'une requete
     *
     * @param string $key clef de la requete
     * @param array $params
     *
     * @return array result
     */
	public function fetchAllByKey($key, $params = array())
	{
		$file = 'queries';
		// if . in key, use first for filename
		if ( false !== strpos($key, '.') ) {
		  list($file, $key) = explode('.', $key);
		}
		$queries = $this->getAdapter()->includeQueriesFile($file);

        if (false === isset($queries[$key])) {
            $this->throwException('database.queries.key.unknown', $key);
        }

        return $this->fetchAll($queries[$key], $params);;
	}

	/**
	 * Prepare a value and places into a piece of text at a placeholder.
     *
     * The placeholder is a question-mark; all placeholders will be replaced
     * with the quoted value.   For example:
	 *
	 * <code>
     * $text = "SELECT * FROM cal WHERE date < ${date} AND id = ${id}";
     * $date = "2005-01-02";
     * $id = 4
     * $safe = $sql->quoteInto($text, array('date' => $date, 'id' => $id));
     * // $safe = "SELECT * FROM cal WHERE date < '2005-01-02' AND id = 4"
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

	    $matches = null;
	    $params = array_map(array($this, 'quote'), $params);
        if (0 < preg_match_all('|\%\{([^\}]+)\}|', $sql, $matches)) {
            foreach($matches[0] as $i => $match) {
                $variableName = $matches[1][$i];
                if (false === isset($params[$variableName])) {
                    $params[$variableName] = '';
                }
                $sql = str_replace($match, $params[$variableName], $sql);
                unset($params[$variableName]);
            }
        }
        return $sql;
	}

	 /**
     * Quote a raw string.
     *
     * @param string $value     Raw string
     * @return string           Quoted string
     */
	public function quote($value)
	{
		if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            return sprintf('%F', $value);
        }
        return "'" . addcslashes($value, "\000\n\r\\'\032") . "'";
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
	 * @return \F\Technical\Database\Service
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
	 *
	 * @return int
	 */
	public function getTransactionLevel()
	{
	    return $this->_transactionLevel;
	}

	/**
     * init queries file directory
     *
     * @params string $path
     *
     * @return \F\Technical\Database\Adapter\Definition
     */
	public function setQueriesPath($path)
	{
		$this->getAdapter()->checkDirExists($path);
		$this->getAdapter()->setQueriesPath($path);
		return $this;
	}

    /**
     * Insert les donnnées dans la table
     *
     * @param string $tablename nom de la table
     * @param array $data données array('field' => 'value')
     *
     * @return id
     */
    public function insert($tablename, $data)
    {
        $this->checkConnection();

        // build the statement
        $cols = $vals = array();
        foreach ($data as $col => $val) {
            $cols[] = $this->_quoteIdentifier($col);
            $vals[] = '%{' . $col . '}';
        }

        $sql = "INSERT INTO "
        . $this->_quoteIdentifier($tablename)
        . ' (' . implode(', ', $cols) . ') '
        . 'VALUES (' . implode(', ', $vals) . ')';

        $sql = $this->prepare($sql, $data);
        $this->getAdapter()->executeDirectQuery($sql);
        f_trace('database.sql.query', array(__FUNCTION__, $sql));
        return $this->getAdapter()->getLastInsertId($tablename);
    }

    /**
     * Update les données dans la table en fonction de la clause where
     *
     * @param string $tablename
     * @param array  $data  array('field' => 'value')
     * @param mixed  $where array('sql', array('key' => value))
     *
     * @return bool
     */
    public function update($tablename, $data, $where=null)
    {
        $this->checkConnection();

        // build the statement
        $set = array();
        foreach ($data as $col => $val) {
            $set[] = $this->_quoteIdentifier($col) . " = " . '%{' . $col . '}';
        }

        $where = $this->_prepareWhere($where);

        $sql = "UPDATE "
        . $this->_quoteIdentifier($tablename)
        . ' SET ' . implode(', ', $set)
        . (($where) ? " WHERE $where" : '');

        $sql = $this->prepare($sql, $data);
        f_trace('database.sql.query', array(__FUNCTION__, $sql));
        return $this->getAdapter()->update($sql);
    }

    /**
     * Delete les données en fonction de la clause where
     *
     * @param string $tablename
     * @param mixed $where array('sql', array('key' => value))
     *
     * @return nb delete
     */
    public function delete($tablename, $where=null)
    {
        $this->checkConnection();

        $where = $this->_prepareWhere($where);

        /**
         * Build the DELETE statement
         */
        $sql = "DELETE FROM "
        . $this->_quoteIdentifier($tablename)
        . (($where) ? " WHERE $where" : '');

        f_trace('database.sql.query', array(__FUNCTION__, $sql));
        return $this->getAdapter()->delete($sql);
    }

    /**
     * prepare whereClause
     *
     * @param array $where array('sql', array('key' => value))
     */
    protected function _prepareWhere($where=null)
    {
        if ( null !== $where ) {
            return $this->prepare($where[0], (true === isset($where[1])?$where[1]:null));
        }
        return null;
    }

    /**
     * Quote an identifier.
     *
     * @param  string $value The identifier or expression.
     *
     * @return string        The quoted identifier and alias.
     */
    protected function _quoteIdentifier($value)
    {
        $q = '`';
    	return ($q . str_replace("$q", "$q$q", $value) . $q);
    }
}