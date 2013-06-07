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
     * @var \Phalcon_Db_Adapter_Mysql
     */
	protected $_cnx = null;

	/**
	 * queries directory
	 *
	 * @var string
	 */
	protected $_queriesPath = null;

	/* (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::fetchAll()
     */
    public function fetchAll ($sql)
    {
        f_dbg(array($sql, $this->_cnx->fetchAll($sql, \Phalcon_Db::DB_ASSOC)));
    	return $this->_cnx->fetchAll($sql, \Phalcon_Db::DB_ASSOC);
    }

	/* (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::isConnected()
     */
    public function isConnected ()
    {
    	return ($this->_cnx instanceof \Phalcon_Db_Adapter_Mysql);
    }

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::executeDirectQuery()
	 */
	public function executeDirectQuery($sql)
	{
		return $this->_cnx->query($sql);
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::connect()
	 */
	public function connect($config)
	{
		$this->_cnx = \Phalcon_Db::factory("Mysql", (object) $config);
		//$this->_activeLog("E:\dev\_logs\db.log");
		return $this;
	}

	/* (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::getConnectConfig()
     */
    public function getConnectConfig()
    {
    	return \F\Technical\Registry\Service::singleton()->getProperty('_databaseConfig');
    }

	/* (non-PHPdoc)
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

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::beginTransaction()
	 */
	public function beginTransaction()
	{
		$this->_cnx->begin();
		return $this;
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::commit()
	 */
	public function commitTransaction()
	{
		$this->_cnx->commit();
        return $this;
	}

	/* (non-PHPdoc)
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
}