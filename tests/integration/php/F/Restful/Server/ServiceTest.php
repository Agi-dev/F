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
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

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
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Restful\Server\Service
     */
    public function s()
    {
        return parent::s();
    }

	/**
	 * Init Server Request
	 *
	 * @param array $extra
	 */
	public static function setHttpRequest($extra = array())
	{
		$extra = array_merge(array(
								'ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
								'ACCEPT_LANGUAGE' => 'fr-FR,fr;q=0.8',
								'QUERY_STRING'    => '',
								'REQUEST_METHOD'  => 'GET',
								'SERVER_PROTOCOL' => 'HTTP/1.1',
								'REDIRECT_URL'    => '/'
						   ), $extra);
		$_SERVER = array_merge($_SERVER, $extra);
	}

	/**
	 * dispatch
	 */
	public function testDispatchWithUnknownHttpMethodDisplayXmlErrorMessage()
	{
		$this->setHttpRequest(array('REQUEST_METHOD' => 'Dummy'));
		$this->s()->dispatch();
		$this->expectOutputString('toto');
	}

	/*public function testDispatchGetAllResourceWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource');
		$this->mock('getHttpRequestedMethod', 'GET');
		$this->mock('getHttpQueryString');
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'httpMethod' => 'get',
			'resource'   => 'uneresource',
			'action'     => 'retrieve',
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}

	public function testDispatchGetResourceByIdWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource/15');
		$this->mock('getHttpRequestedMethod', 'GET');
		$this->mock('getHttpQueryString');
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'httpMethod' => 'get',
			'resource'   => 'uneresource',
			'action'     => 'retrieve',
			'id'         => 15
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}

	public function testDispatchGetResourcePropertyByIdWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource/15/name');
		$this->mock('getHttpRequestedMethod', 'GET');
		$this->mock('getHttpQueryString');
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'httpMethod' => 'get',
			'resource'   => 'uneresource',
			'action'     => 'retrieve',
			'id'         => 15,
			'property'	 => 'name'
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}

	public function testDispatchGetFilteredResourceWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource');
		$this->mock('getHttpRequestedMethod', 'GET');
		$this->mock('getHttpQueryString', 'firstname=vincent&age=15');
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'httpMethod' => 'get',
			'resource'   => 'uneresource',
			'action'     => 'retrieve',
			'filter'	 => array(
				'firstname' => 'vincent',
				'age'		=> 15
			)
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}

	public function testDispatchCreateResourceWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource');
		$this->mock('getHttpRequestedMethod', 'POST');
		$post = array (
			'name' => 'paul',
			'lastname' => 'ricard',
			'age' => 15,
			'weight' => 67.8
		);
		$this->mock('getRawHttpRequest', $post);
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'httpMethod' => 'post',
			'resource'   => 'uneresource',
			'action'     => 'create',
			'data'       => $post
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}

	public function testDispatchUpdateResourceByIdWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource/15');
		$this->mock('getHttpRequestedMethod', 'PUT');
		$post = array (
			'lastname' => 'ricard',
			'weight' => 67.8
		);
		$this->mock('getRawHttpRequest', $post);
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'id'         => 15,
			'httpMethod' => 'put',
			'resource'   => 'uneresource',
			'action'     => 'update',
			'data'       => $post
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}

	public function testDispatchDeleyeResourceByIdWithSuccess()
	{
		$this->mock('getHttpRequestedPath', '/uneresource/15');
		$this->mock('getHttpRequestedMethod', 'DELETE');
		$this->mock('dispatch');
		$this->assertInstanceOfService($this->s()->dispatch());
		$expected = array(
			'id'         => 15,
			'httpMethod' => 'delete',
			'resource'   => 'uneresource',
			'action'     => 'delete',
		);
		$this->assertEquals(array($expected), $this->m()->getCallArgs('dispatch'));
	}*/
}