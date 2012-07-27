<?php
// @codeCoverageIgnoreStart
/**
 * P\Technical\Base\Adapter\Table\Mock is the mock adapter
 * for the service.
 *
  * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Base
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Base\Table\Adapter;

/**
 * @see F/Technical/base/Table/Adapter/Definition.php
 */
require_once 'F/Technical/base/Table/Adapter/Definition.php';

/**
 * @see F/Technical/Base/Adapter/Mock.php
 */
require_once 'F/Technical/Base/Table/Adapter/Mock.php';

/**
 * F\Technical\Base\Adapter\Mock is the mock adapter
 * for the service.
 *
 * @category F
 * @package F\Technical\Base\Adapter
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Mock
    extends \F\Technical\Base\Adapter\Mock
         implements Definition
{
	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::fetchAll()
	 */
	public function fetchAll ($key, $sqlParams = array())
	{
		$args = func_get_args();
		return $this->storeCallAndReturnExpectedResult(__FUNCTION__, $args);
	}

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::update()
	 */
	public function update($data, $where, $tablename)
    {
        $args = func_get_args();
        return $this->storeCallAndReturnExpectedResult(__FUNCTION__, $args);
    }

	/**
	 * (non-PHPdoc)
	 * @see F\Technical\Base\Table\Adapter.Definition::beginTransaction()
	 */
    public function beginTransaction()
    {
        $args = func_get_args();
        return $this->storeCallAndReturnExpectedResult(__FUNCTION__, $args);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Base\Table\Adapter.Definition::rollbackTransaction()
     */
    public function rollbackTransaction()
    {
        $args = func_get_args();
        return $this->storeCallAndReturnExpectedResult(__FUNCTION__, $args);
    }

    /**
     * (non-PHPdoc)
     * @see F\Technical\Base\Table\Adapter.Definition::commitTransaction()
     */
    public function commitTransaction()
    {
        $args = func_get_args();
        return $this->storeCallAndReturnExpectedResult(__FUNCTION__, $args);
    }
}
// @codeCoverageIgnoreEnd