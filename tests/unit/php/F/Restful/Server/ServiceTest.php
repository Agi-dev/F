<?php
/**
 * F\Restful\Server\Service is
 * a class to handle server operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Restful\Server\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Restful\Server;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

/**
 * F\Restful\Server\Service is
 * a class to handle server operations.
 *
 * @category F
 * @package F\Restful\Server
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return \F\Restful\Server\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return \F\Restful\Server\Adapter\Mock
	 */
	public function m()
	{
		return parent::m();
	}

	/**
	 * @static
	 *
	 * @param array $extra
	 *
	 * @return array
	 */
	public static function getHttpRequest($extra = array())
	{
		return array_merge(array(
								'ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
								'ACCEPT_LANGUAGE' => 'fr-FR,fr;q=0.8',
								'QUERY_STRING'    => '',
								'REQUEST_METHOD'  => 'GET',
								'SERVER_PROTOCOL' => 'HTTP/1.1',
						   ), $extra);
	}

    /**
     * dispatch
     */
	public function testDispatchWithSuccess()
    {
    	$this->mock('getRequest', $this->getHttpRequest());
		$this->s()->dispatch();
		$this->expectOutputString('Dispatch Success');
    }
}