<?php
// @codeCoverageIgnoreStart
/**
 * F\Technical\Base\Service is a class to handle Base operations.
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

namespace F\Technical\Base;

require_once 'F/Technical/I18n/Service.php';

/**
 * F\Technical\Base\Service is a class to handle Base operations.
 *
 * @category F
 * @package F\Technical\Base
 * @copyright Copyright (c) 2011 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
abstract class Service
{
	/**
	 * @var array
	 */
	protected static $_singletons = array();

	/**
	 * @var F_Technical_Abstract_Adapter_Interface
	 */
	protected $_adapter;

	/**
	 * Returns the singleton of this service
	 *
	 * @return F\Technical\Base\Service
	 *
	 * @throws Exception if an error occured
	 */
	public static function singleton()
	{
		$class = get_called_class();
		if (false === isset(self::$_singletons[$class])) {
			self::$_singletons[$class] = self::factory();
		}
		return self::$_singletons[$class];
	}

	/**
	 * Returns a new instance of this service
	 *
	 * @return F\Technical\Base\Service
	 *
	 * @throws Exception if an error occured
	 */
	public static function factory($adapter = null)
	{
		return new static($adapter);
	}

	/**
	 * Constructs a new instance
	 *
	 * @param mixed $adapter the adapter
	 *
	 * @return F\Technical\Base\Service
	 *
	 * @throws Exception if an error occured
	 */
	public function __construct($adapter = null)
    {
        if (null === $adapter) {
            $adapterClass = $this->getNamespace($this->getClassType())
                . '\\Adapter\\Standard';
            if (false === @class_exists($adapterClass, true)) {
                require_once str_replace(array('_', '\\'), '/', $adapterClass)
                    . '.php';
            }
            $adapter = new $adapterClass;
        }

        $this->setAdapter($adapter);

        if (true === method_exists($this, 'init')) {
            $this->init();
        }
    }

    /**
     * Sets the underlying adapter
     *
     * @param mixed $adapter
     *
     * @return F\Technical\Base\Service
     *
     * @throws Exception if an error occured
     */
    public function setAdapter($adapter)
    {
    	$this->checkAdapter($adapter);
    	$this->_adapter = $adapter;
       	return $this;
    }

    /**
     * Returns the underlying adapter
     *
     * @return mixed
     */
    public function getAdapter()
    {
    	return $this->_adapter;
    }


    /**
     * Throws the specified localized exception
     *
     * @param string $key the exception key
     * @param string $arg1 the first message variable
     * @param string $arg2 the second message variable
     * @param string ...
     *
     * @throws RuntimeException always
     */
    public function throwException()
    {
    	$args = func_get_args();
    	 throw $this->throwExceptionArray(
    	   0 === count($args) ? 'unexpected' : array_shift($args), $args
    	);
    }

    /**
     * Returns the exception code from the specified key.
     *
     * @param string $value the key
     *
     * @return integer
     */
    protected function _getExceptionCodeFromKey($value)
    {
    	$code = 500;
    	$lastPointPosition = strrpos($value, '.');

    	if (false !== $lastPointPosition) {
    		$suffix = strtolower(substr($value, $lastPointPosition + 1));
    		// 400 - Bad Request
    		// 401 - Unauthorized
	        // 404 - Not Found
	        // 409 - Conflict
	        // 412 - Precondition Failed
	        // 500 - Internal Server Error
	        // 503 - Service Unavailable
	        // 510 - Locked
	        // 511 - Database failure
    		$mapping = array(
				'conflict'          => 409,
				'badformat'         => 412,
				'dbfailure'         => 511,
				'denied'            => 403,
				'empty'             => 412,
				'error'             => 500,
				'missing'           => 400,
				'notauthentified'   => 401,
				'notempty'          => 412,
    		    'notfound'          => 404,
				'notyetimplemented' => 400,
				'unexpected'        => 500,
				'unknown'           => 404,
				'toshort'           => 412,
    		    'notconnected'      => 503,
    		    'alreadyexist'      => 409
    		);
    		if (true === isset($mapping[$suffix])) {
    			$code = (int) $mapping[$suffix];
    		}
    	}

    	return $code;
    }

    /**
     * Throws the specified localized exception
     *
     * @param string $value the exception i18n key
     * @param array $args the variables
     *
     * @throws RuntimeException always
     */
    public function throwExceptionArray($value, $args = null)
    {

        if (true === is_array($value) && 0 === count($args)) {
    		$args = $value;
    		$value = array_shift($args);
    	}
    	$args = true === is_array($args) ? $args : array();
    	$origValue = $value;
    	$value2 = $this->getI18n($value, $args);

    	if ($value === $value2) {
    		if (false !== strpos($value2, '.') && false === strpos($value2, ' ')) {
    			$value2 = str_replace('.', ' ', $value2);
    		}
    	}

    	$value = $value2;

    	return new \RuntimeException(
        	$value,
         	$this->_getExceptionCodeFromKey($origValue)
    	);
    }

   /**
    * Recupère la traduction de $key
    * @param unknown_type $key
    * @param unknown_type $args
    *
    * @return sting
    */
   function getI18n($key, $args = null)
   {
       return \F\Technical\I18n\Service::singleton()->translate($key, $args);
   }

    /**
     * Checks if specified adapter if valid (i.e. implements interface)
     *
     * @param mixed $adapter
     *
     * @return F\Technical\Base\Service
     *
     * @throws Exception if an error occured
     */
    public function checkAdapter($adapter)
    {
    	$adapterInterfaceClass = $this->getNamespace($this->getClassType())
    	. '\\Adapter\\Definition';

    	// Contrôle désactivé : le mock n'hérite plus de définition
//     	if (false === ($adapter instanceof $adapterInterfaceClass)) {
//     	    throw new \RuntimeException('class.denied : '.$adapterInterfaceClass.', '.get_class($adapter));
//     	     $this->throwException(
//              'class.denied', $adapterInterfaceClass, $adapter
//     		 );
//     	}

    	return $this;
    }

    /**
     * Returns the current class namespace
     *
     * @return string the class namespace
     */
    public function getNamespace($type = null)
    {
    	return str_replace('/', '\\',
    	   dirname(str_replace('\\', '/',
    	       null === $type ? get_class($this) : $type))
    	   );
    }

    /**
     * Returns the class type.
     *
     * @return string
     */
    public function getClassType()
    {
    	return get_class($this);
    }

    /**
     * trace message
     *
     * @param unknown_type $key
     * @param unknown_type $params
     */
    public function trace($key, $params)
    {
    	return $this->getAdapter()->trace($key, $params);
    }
    // @codeCoverageIgnoreEnd
}