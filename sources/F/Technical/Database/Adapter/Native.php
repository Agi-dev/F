<?php
/**
 * F\Technical\Database\Adapter\Native is
 * the native adapter for the database service,
 * that implements PHP natives primitives.
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
 * @see F/Technical/Database/Adapter/Definition.php
 */
require_once 'F/Technical/Database/Adapter/Definition.php';

require_once 'F/Technical/Filesystem/Service.php';

/**
 * F\Technical\Database\Adapter\Native is the native adapter
 * for the database service, that implements PHP natives primitives.
 *
 * @category   F
 * @package    F\Technical\Database\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class Native
    implements Definition
{
    /**
     * resource database
     *
     * @var \Zend_Db_Adapter_Mysqli
     */
	protected $_cnx = null;

	/**
	 * queries directory
	 *
	 * @var string
	 */
	protected $_queriesPath = null;

	/**
	 * (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::fetchAll()
     */
    public  function fetchAll ($sql)
    {
        return $this->_cnx->fetchAll($sql);
    }

	/**
	 * (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::isConnected()
     */
    public function isConnected ()
    {
        return ($this->_cnx instanceof \mysqli);
    }

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::executeDirectQuery()
	 */
	public function executeDirectQuery($sql)
	{
		return $this->_cnx->query($sql);
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::connect()
	 */
	public function connect($config)
	{
        $this->_cnx = new \mysqli($config['host'], $config['username'], $config['password'], $config['dbname'],
                                    (true === isset($config['port']) ? $config['port']:null));

        if ($this->_cnx->connect_errno) {
            throw new \RuntimeException($mysqli->connect_errno . ' ' . $mysqli->connect_error);
        }
		return $this;
	}

	/**
	 * (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::getConnectConfig()
     */
    public function getConnectConfig()
    {
    	return \F\Technical\Registry\Service::singleton()->getProperty('_databaseConfig');
    }

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getFileContent()
	 */
	public function getFileContent($filename)
	{
		return \F\Technical\Filesystem\Service::singleton()->getFileContents($filename);
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::includeQueriesFile()
	 */
	public function includeQueriesFile($file)
	{
		return include $this->_queriesPath . '/' . $file .'.php';
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::beginTransaction()
	 */
	public function beginTransaction()
	{
		$this->_cnx->beginTransaction();		
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::commit()
	 */
	public function commitTransaction()
	{
		$this->_cnx->commit();
        return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::rollback()
	 */
	public function rollbackTransaction()
	{
		$this->_cnx->rollback();
        return $this;
	}

	 /**
	  * (non-PHPdoc)
	  * @see F\Technical\Database\Adapter.Definition::setQueriesPath()
	  */
	 public function setQueriesPath($path)
	 {
	 	$this->_queriesPath = $path;
	 	return $this;
	 }

	 /**
	  * (non-PHPdoc)
	  * @see F\Technical\Database\Adapter.Definition::checkDirExists()
	  */
	 public function checkDirExists($path)
	 {
	 	\F\Technical\Filesystem\Service::singleton()->checkDirExists($path);
	 	return $this;
	 }

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::lastInsertId()
	 */
	public function getLastInsertId($tablename)
    {
        return $this->_cnx->lastInsertId($tablename);
    }

    /**
     * active log
     *
     * @param string $logname
     *
     * @return  F\Technical\Database\Adapter\Native
     */
	protected function _activeLog($logname)
	{
		$logger = new \Phalcon_Logger("File", $logname);
		$this->_cnx->setLogger($logger);
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::insert()
	 */
	public function insert($sql)
	{
        return $this->executeDirectQuery($sql)->rowCount();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::delete()
	 */
	public function delete($sql)
	{
        return $this->executeDirectQuery($sql)->rowCount();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::update()
	 */
	public function update($sql)
	{
		return $this->executeDirectQuery($sql)->rowCount();
	}
}