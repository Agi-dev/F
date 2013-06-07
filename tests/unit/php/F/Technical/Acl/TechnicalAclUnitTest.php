<?php
/**
 * F\Technical\Acl\TechnicalAcl is
 * a class to handle acl operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Acl\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Acl;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Technical\Acl\Service is
 * a class to handle acl operations.
 *
 * @category F
 * @package F\Technical\Acl
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class TechnicalAclUnitTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Technical\Acl\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Technical\Acl\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

    /**
     * just for saying there is no test
     */
	public function testToImplement()
    {
    }
}