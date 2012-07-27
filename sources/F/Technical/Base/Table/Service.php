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
     * Check id exist for table _tablename
     *
     * @param mixed table
     *
     * @return true if exist, throw exception if not
     * @throws RuntimeException table.id.notfound
     */
    public function checkId($id)
    {
    	$result = $this->getById($id);
    	if (true === isset($result[0]['id']) ) {
            return true;
        }
        $this->throwException('table.id.notfound', $id, $this->_tablename);
    }

    /**
     * get user by id
     *
     * @param mixed $id
     *
     * @return array
     */
    public function getById($id)
    {
        return $this->getAdapter()->fetchAll($this->_tablename .
                                             '.getById', array('id' => $id));
    }

    /**
     * update data
     *
     * @param array $data
     * @param array $where
     *
     * @return int nb updated
     */
    public function update($data, $where)
    {
    	$this->_beginTransaction();
    	try {
    		$nb = $this->getAdapter()->update($data, $where, $this->_tablename);
    		$this->_commitTransaction();
    	} catch (Exception $e) {
    		$this->_rollbackTransaction();
    		$this->throwException('sql.update.dbfailure', $e->getMessage());
    	}
    	return $nb;
    }

    /**
     * Begin transaction
     *
     * @return F\Technical\Base\Table\Service
     */
    protected function _beginTransaction()
    {
        $this->getAdapter()->beginTransaction();
        return $this;
    }

    /**
     * Commit DB transaction
     *
     * @return F\Technical\Base\Table\Service
     */
    protected function _commitTransaction()
    {
        $this->getAdapter()->commitTransaction();
        return $this;
    }

    /**
     * Rollback DB transaction
     *
     * @return F\Technical\Base\Table\Service
     */
    protected function _rollbackTransaction()
    {
        $this->getAdapter()->rollbackTransaction();
        return $this;
    }
}
// @codeCoverageIgnoreEnd