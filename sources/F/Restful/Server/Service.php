<?php
/**
 * F\Restful\Server\Service is a class to handle server operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Restful\Server
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Restful\Server;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Restful\Server\Service is a class to handle server operations.
 *
 * @category F
 * @package F\Restful\Server
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service
    extends \F\Technical\Base\Service
{
	/**
	 * Returns the singleton of this service
	 *
	 * @return \F\Restful\Server\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}

	/**
	 * Returns an instance of this service
	 *
	 * @param null $adapter
	 *
	 * @return \F\Restful\Server\Service
	 */
	public static function factory($adapter = NULL)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return \F\Restful\Server\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

	/**
	 * Dispatch restful request
	 *
	 * request format :
	 *  get all resource            => /:resource (GET)
	 *  get resource by id          => /:resource/:id (GET)
	 *  get resource property by id => /:resource/:id/:property (GET)
	 *  get resource filtered       => /:resource?filter1=value&filter2=value2...&filterN=valueN
	 *
	 *  create resource             => /:resource (POST)
	 *
	 *  update resource by id       => /:resource/:id (PUT)
	 *
	 *  delete all resources        => /:resource (DELETE)
	 *  delete resource by id       => /:resource/:id (DELETE)
	 *
	 * @throws \RuntimeException
	 * @return \F\Restful\Server\Service
	 */
	public function dispatch()
	{
		try {
			$request = array();
			$request['httpMethod'] = trim(strtolower($this->getAdapter()->getHttpRequestedMethod()));

			// analyse query
			$tokens = explode('/', $this->getAdapter()->getHttpRequestedPath());
			array_shift($tokens);

			// First token is resource
			$request['resource'] = array_shift($tokens);

			// route query
			switch ($request['httpMethod']) {
				/**
				 * GET
				 */
				case 'get':
					$request['action'] = 'retrieve';

					// querystring  => filters
					$qs =  $this->getAdapter()->getHttpQueryString();
					if (false === empty($qs)) {
						$list = explode('&', $qs);
						foreach ($list as $filter) {
							list($f, $v) = explode('=', $filter);
							$request['filter'][$f] = $v;
						}
					}

					// 2e token must be id
					if (0 < count($tokens)) {
						$request['id'] = array_shift($tokens);

						// 3e token must be property
						if (0 < count($tokens)) {
							$request['property'] = array_shift($tokens);
						}
					}

					break;
				/**
				 * POST
				 */
				case 'post':
					$request['action'] = 'create';
					$request['data']   = $this->getAdapter()->getRawHttpRequest();
					break;
				/**
				 * DELETE
				 */
				case 'delete':
					$request['action'] = 'delete';
					// 2e token must be id
					if (0 < count($tokens)) {
						$request['id'] = array_shift($tokens);
					}
					break;
				/**
				 * PUT
				 */
				case 'put':
					$request['action'] = 'update';
					$request['data']   = $this->getAdapter()->getRawHttpRequest();
					// 2e token must be id
					if (0 < count($tokens)) {
						$request['id'] = array_shift($tokens);
					}
					break;
				default:
					throw $this->getExceptionToThrow('restful.httpmethod.notsupported', $request['httpMethod']);
			}

			$this->getAdapter()->dispatch($request);
			return $this;
		} catch(\Exception $e) {
			//throw $e;
			$this->getAdapter()->renderExceptionError($e);
			return $this;
		}

	}
}

