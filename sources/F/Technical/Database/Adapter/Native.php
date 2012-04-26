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
	/* (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::fetchAll()
     */
    public function fetchAll ($cnx, $sql, $sqlParams)
    {
        return $cnx->fetchAll($sql, $sqlParams);
    }
    
	/* (non-PHPdoc)
     * @see F\Technical\Database\Adapter.Definition::isConnected()
     */
    public function isConnected ($cnx)
    {
        // Utilisation de la classe surchargée dans ASM
        return $cnx->isConnected();
    }
    
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::executeDirectQuery()
	 */
	public function executeDirectQuery($cnx, $sql) {
		return $cnx->query($sql);
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getConnection()
	 */
	public function getConnection() {
		return \Zend_Db_Table::getDefaultAdapter();
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::connect()
	 */
	public function connect($cnx) {
		$cnx->getConnection();
		return $this;
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getFileContent()
	 */
	public function getFileContent($filename) {
		return file_get_contents($filename);
	}
	
	/**
	 * Récupère la configuration de la base de données courante
	 * @param unknown_type $cnx
	 */
	public function getDbConfig($cnx) 
	{
	    return $cnx->getConfig();
	}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getDbDateToday()
	 */
	public function getDbDateToday() 
	{
		return date('Y-m-d H:i:s');
	}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getDbTableObject()
	 */
	public function getDbTableObject($tablename) 
	{
	    $class = 'Table_';
	    $class .= ucfirst(substr($tablename, 0, -4));
	    require_once (APP_ROOT . '/application/models/' .str_replace ('_', '/', $class) .'.php');
	    $class = 'Model_' . $class;
	    return  new $class();
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::insert()
	 */
	public function insert($dbtable, $data) 
	{
		return $dbtable->insert($data) ;
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::lastInsertId()
	 */
	public function lastInsertId($dbtable) 
	{
		return \Oft_App::getInstance()->getDb()->lastInsertId($dbtable);
	}
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getIdColumn()
	 */
	public function getIdColumn($dbtable) 
	{
		return $dbtable->getIdColumn();
	}
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::beginTransaction()
	 */
	public function beginTransaction($cnx) 
	{
		$cnx->beginTransaction();
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::commit()
	 */
	public function commitTransaction($cnx) 
	{
		$cnx->commit();
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::rollback()
	 */
	public function rollbackTransaction($cnx) 
	{
		$cnx->rollBack();
	}
}