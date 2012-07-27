<?php
// @codeCoverageIgnoreStart
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
	/* (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::fetchAll()
	*/
	public function fetchAll ($key, $sqlParams = array())
	{
		return \F\Technical\Database\Service::singleton()->fetchAllByKey($key, $sqlParams);
	}

/**
     * (non-PHPdoc)
     * @see F\Technical\Base\Table\Adapter.Definition::update()
     */
    public function update($data, $where, $tablename)
    {
    	return \F\Technical\Database\Service::singleton()->update($tablename, $data, $where);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Base\Table\Adapter.Definition::beginTransaction()
     */
    public function beginTransaction()
    {
    	\F\Technical\Database\Service::singleton()->beginTransaction();
    	return $this;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Base\Table\Adapter.Definition::rollbackTransaction()
     */
    public function rollbackTransaction()
    {
    	\F\Technical\Database\Service::singleton()->rollbackTransaction();
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Base\Table\Adapter.Definition::commitTransaction()
     */
    public function commitTransaction()
    {
    	\F\Technical\Database\Service::singleton()->commitTransaction();
        return $this;
    }
}
// @codeCoverageIgnoreEnd