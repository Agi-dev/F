<?php
/**
 * F\Technical\Base\Table\Adapter\Native is
 * the native adapter for the i18n service,
 * that implements PHP natives primitives.
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
 *
 * @see F/Technical/Base/Table/Adapter/Definition.php
 */
require_once 'F/Technical/Base/Table/Adapter/Definition.php';

/**
 * F\Technical\Base\Table\Adapter\Native is the native adapter
 * for the i18n service, that implements PHP natives primitives.
 *
 * @category W
 * @package F\Technical\Base\Table\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Native implements Definition
{
	/**
	 * Service historique
	 * @var \F\Technical\Base\Table\History\Definition
	 */
    protected $_history;
    
    public function __construct() {}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::insert()
	 */
	public function insert($data, $tablename) 
	{
	    return \F\Technical\Database\Service::singleton()
		    ->insert($data, $tablename);
	}
	/**
	 * check history service 
	 */
	protected function _checkHistory()
	{
	    if (false === ($this->_history instanceof \F\Technical\Base\Table\History\Definition) ) {
	        throw new \RuntimeException('History service must implements' .
	                                ' \F\Technical\Base\Table\History\Definition');
	    }
	    return $this;
	}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::getCuidUserConnected()
	 */
	public function getCuidUserConnected() 
	{
		if ( \Oft_App::getInstance()->getAuth()->getIdentity() ) {
	        return \Oft_App::getInstance()->getAuth()->getIdentity()->getCuid();
		}
		else {
		    throw new \RuntimeException('Aucun utilisateur connecté');
		} 
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getHistoryCreateType()
	 */
	public function getHistoryCreateType()
	{
		return $this->_history->getCreateType();
	}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getHistoryDeleteType()
	 */
	public function getHistoryDeleteType()
	{
		return $this->_history->getDeleteType();
	}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Database\Adapter.Definition::getHistoryUpdateType()
	 */
	public function getHistoryUpdateType()
	{
		return $this->_history->getUpdateType();
	}
	
	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::saveHistory()
	 */
	public function saveHistory($tablename, $cuid, $id, $type, $new, $old = null) 
	{
		return $this->_history->save($tablename, $cuid, $id, $type, $new, $old);
	}
	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::getIdColumn()
	 */
	public function getIdColumn($tablename) 
	{
		return \F\Technical\Database\Service::singleton()->getIdColumn($tablename);
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::fetchAll()
	*/
	public function fetchAll ($sql, $sqlParams = array())
	{
		return \F\Technical\Database\Service::singleton()->fetchAll($sql, $sqlParams);
	}
	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::beginTransaction()
	 */
	public function beginTransaction() 
	{
		\F\Technical\Database\Service::singleton()->beginTransaction();
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::commitTransaction()
	 */
	public function commitTransaction() 
	{
		\F\Technical\Database\Service::singleton()->commitTransaction();
	}

	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::rollbackTransaction()
	 */
	public function rollbackTransaction() 
	{
		\F\Technical\Database\Service::singleton()->rollbackTransaction();
	}
}