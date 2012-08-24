<?php
// @codeCoverageIgnoreStart
/**
 * F\Restful\Server\Adapter\Definition
 * is the adapter interface for the server service.
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

namespace F\Restful\Server\Adapter;

/**
 * F\Restful\Server\Adapter\Definition
 * is the adapter interface for the server service
 * that define all the primitives required.
 *
 * @category   F
 * @package    F\Restful\Server\Adapter
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
interface Definition
{
	public function dispatch($request);

	public function renderExceptionError($e);

	public function getHttpRequestedPath();

	public function getHttpRequestedMethod();

	public function getRawHttpRequest();

	public function getHttpQueryString();
}
// @codeCoverageIgnoreEnd