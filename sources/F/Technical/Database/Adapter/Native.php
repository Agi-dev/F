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

	/* (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::fetchAll()
     */
    public function fetchAll ($sql)
    {
        return $this->_cnx->fetchAll($sql);
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
		$this->_cnx->setFetchMode(\Phalcon_Db::DB_ASSOC);
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

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getDbDateToday()
	 */
	public function getDbDateToday()
	{
		throw new \RuntimeException (
			"Feature '" . __METHOD__ . "' not yet implemented In Adapter Native"
		);
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::beginTransaction()
	 */
	public function beginTransaction()
	{
		throw new \RuntimeException (
			"Feature '" . __METHOD__ . "' not yet implemented In Adapter Native"
		);
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::commit()
	 */
	public function commitTransaction()
	{
		throw new \RuntimeException (
			"Feature '" . __METHOD__ . "' not yet implemented In Adapter Native"
		);
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::rollback()
	 */
	public function rollbackTransaction()
	{
		throw new \RuntimeException (
			"Feature '" . __METHOD__ . "' not yet implemented In Adapter Native"
		);
	}
}