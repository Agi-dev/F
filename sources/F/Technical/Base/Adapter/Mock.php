<?php
// @codeCoverageIgnoreStart
/**
 * P\Technical\Base\Adapter\Mock is the mock adapter
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

namespace F\Technical\Base\Adapter;

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
abstract class Mock
{
	private $_calls;
	private $_results;

	public function __construct()
	{
		$this->_calls = array('*all*');
		$this->_results = array();
	}
	/**
	 * Stores the specified call and return the registered result
	 *
	 * @param string $method the method
	 * @param array $args the arguments list
	 *
	 * @return mixed the expected result
	 *
	 * @throws \Exception if an error occured
	 */
	public function storeCallAndReturnExpectedResult($method, $args)
	{
		if (false === isset($this->_calls[$method])) {
			$this->_calls[$method] = array();
		}
		$this->_calls[$method][] = $args;
		$this->_calls['*all*'][] = array($method, $args);
		if (false === isset($this->_results[$method])) {
			throw new \RuntimeException(
             "No results registered for method '$method'"
			);
		}
		if (0 === count($this->_results[$method])) {
			throw new \RuntimeException(
             "No more results registered for method '$method'"
			);
		}
		$result = array_shift($this->_results[$method]);

		if (true === ($result instanceof \Exception)) {
			throw $result;
		}
		return $result;
	}

	public function mock($method, $result = null)
	{
		if (false === isset($this->_results[$method])) {
			$this->_results[$method] = array();
		}
		$this->_results[$method][] = $result;

		return $this;
	}
	/**
	 * Returns the call parameter for the specified method call
	 * if call has been registered.
	 *
	 * @param string $method the method name
	 * @param integer $index the call index (default: 0)
	 *
	 * @return mixed
	 *
	 * @throws Exception if index does not exist
	 */
	public function getCallArgs($method = null, $index = 0)
	{
		if (null !== $method) {
			if (false === isset($this->_calls[$method][$index])) {
				throw new \RuntimeException(
                 "No registered calls #$index for method $method()",
				404
				);
			}

			return $this->_calls[$method][$index];
		} else {
			if (false === isset($this->_calls['*all*'][$index])) {
				throw new \RuntimeException(
                 "No registered calls #$index",
				404
				);
			}

			return $this->_calls['*all*'][$index];
		}
	}

	/**
	 * Returns the number of times the method was called
	 *
	 * @param string $method the method name
	 *
	 * @return integer
	 */
	public function countCalls($method = null)
	{
		if (null !== $method) {
			if (false === isset($this->_calls[$method])) {
				return 0;
			}
			return count($this->_calls[$method]);
		} else {
			return count($this->_calls['*all*']);
		}
	}
	public function listCalls()
	{
		$calls = array();

		foreach($this->_calls['*all*'] as $call) {
			$calls[] = $call[0];
		}

		return $calls;
	}

	public function trace($key, $params)
	{
		$args = func_get_args();
		$this->mock('trace');
		return $this
			->markMethodExecutionAndReturnExpectedResult(__FUNCTION__, $args);
	}

	public function __call($method, $args)
	{
	    $definition = str_replace('Mock', 'Definition', get_class($this));

		if(true === in_array($method, get_class_methods($definition))) {
			return $this->storeCallAndReturnExpectedResult($method, $args);
		} else {
			throw new \Exception('Vérifier que \'' . $method . '\' se trouve dans Definition');
		}
	}
}
// @codeCoverageIgnoreEnd