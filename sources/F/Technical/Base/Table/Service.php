<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Base\Service is a class to handle Base operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Base\Table
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Table;

/**
 * F\Technical\Base\Table\Service is a class to handle Base table operations.
 *
 * @category F
 * @package F\Technical\Base\Table
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
abstract class Service
    extends \F\Technical\Base\Service
{
    protected $_tablename;

    /**
     * Returns the underlying adapter.

     * @return F\Technical\Base\Table\Adapter\Definition
     */
    public function getAdapter()
    {
    	return parent::getAdapter();
    }

    /**
     * Check id exist for table _tablename
     *
     * @param mixed table
     *
     * @return true if exist, throw exception if not
     * @throws RuntimeException table.id.notfound
     */
    public function checkId($id)
    {
    	$result = $this->getAdapter()->fetchAll($this->_tablename . '.checkId', array('id' => $id));
    	if (true === isset($result[0]['id']) ) {
            return true;
        }
        $this->throwException('table.id.notfound', $id, $this->_tablename);
    }

    /**
     * update data
     * Enter description here ...
     * @param unknown_type $data
     * @param unknown_type $where
     */
    public function update($data, $where)
    {
    	$this->beginTransaction();
    	try {
    		$this->getAdapter()->update($data, $where, $this->_tablename);
    		$this->getAdapter()->commitTransaction();
    	} catch (Exception $e) {
    		$this->getAdapter()->rollbackTransaction();
    		$this->throwException('sql.update.dbfailure', $e->getMessage());
    	}
    	return $this;
    }
}
// @codeCoverageIgnoreEnd