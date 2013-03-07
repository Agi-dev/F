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
        if (true === isset($result['id'])) {
            return true;
        }
        $this->throwException('table.id.notfound', $id, $this->_tablename);
    }

    /**
     * get by id
     *
     * @param mixed $id
     *
     * @return array
     */
    public function getById($id)
    {
        $result = $this->_fetchAll($this->_tablename . '.getById', array('id' => $id));
        return (true === isset($result[0]) ? $result[0] : $result);
    }

    /**
     * get All
     *
     * @return array
     */
    public function getAll()
    {
        return $this->_fetchAll($this->_tablename . '.getAll');
    }

    /**
     * update data
     *
     * @param array $data
     * @param array $where array('sql', array('key' => value))
     *
     * @return int nb updated
     */
    public function update($data, $where = array())
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
     * insert data
     *
     * @param array $data
     *
     * @return id created
     */
    public function insert($data)
    {
        $this->_beginTransaction();
        try {
            $id = $this->getAdapter()->insert($data, $this->_tablename);
            $this->_commitTransaction();
        } catch (Exception $e) {
            $this->_rollbackTransaction();
            $this->throwException('sql.insert.dbfailure', $e->getMessage());
        }
        return $id;
    }

    /**
     * delete data
     *
     * @param array $where
     *
     * @return int nb deleted
     */
    public function delete($where)
    {
        $this->_beginTransaction();
        try {
            $nb = $this->getAdapter()->delete($where, $this->_tablename);
            $this->_commitTransaction();
        } catch (Exception $e) {
            $this->_rollbackTransaction();
            $this->throwException('sql.delete.dbfailure', $e->getMessage());
        }
        return $nb;
    }

    /**
     * Begin transaction
     *
     * @return \F\Technical\Base\Table\Service
     */
    protected function _beginTransaction()
    {
        $this->getAdapter()->beginTransaction();
        return $this;
    }

    /**
     * Commit DB transaction
     *
     * @return \F\Technical\Base\Table\Service
     */
    protected function _commitTransaction()
    {
        $this->getAdapter()->commitTransaction();
        return $this;
    }

    /**
     * Rollback DB transaction
     *
     * @return \F\Technical\Base\Table\Service
     */
    protected function _rollbackTransaction()
    {
        $this->getAdapter()->rollbackTransaction();
        return $this;
    }

    /**
     * fetch all by key and params
     *
     * @param string $key
     * @param array $params
     *
     * @return array
     */
    public function _fetchAll($key, $params = array())
    {
        return $this->getAdapter()->fetchAll($key, $params);
    }
}
// @codeCoverageIgnoreEnd