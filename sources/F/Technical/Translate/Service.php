<?php
/**
 * F\Technical\Translate\Service is a class to handle translate operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Technical\Translate
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Translate;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\Translate\Service is a class to handle translate operations.
 *
 * @category F
 * @package F\Technical\Translate
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
	 * @return F\Technical\Translate\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\Translate\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\Translate\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}

    /**
     * Init de base
     *
     */
    public function __construct($adapter=null)
    {
        parent::__construct($adapter);
    	$this->addRepository(
            realpath(dirname(__FILE__) . '/../../resources/i18n'));
    }

    /**
     * Translates the specified message (key) using arguments and current
     * locale.
     *
     * @param string $key the message key
     * @param array|null $args the message arguments
     *
     * @return string
     *
     * @throws Exception if an error occured
     */
    public function translate($key, $args=null)
    {
        $message = $this->getAdapter()->getKey($key,
            $this->getAdapter()->getCurrentLocale());

        if (false === isset($message)) {
            return str_replace('.', ' ', $key);
        }

        if (null !== $args && false === is_array($args) ) {
            $args = array($args);
        }

        // si aucun argument n'est passé, on se contente de retourner le
        // message
        if (false === empty($args)) {
        	// On remplace la structure %{n} par l'argument n-1 dans le
        	// message - sinon on laisse %{n}
        	$message = preg_replace('/\%\{(\d+)\}/e',
                'isset($args[$1-1]) ? $args[$1-1] : "%{$1}";', $message);
        }
        return $message;
    }


    /**
     * Set Current Locale Translate
     *
     * @param unknown_type $locale
     *
     * @return W_Technical_Translate_Service
     */
    public function setCurrentLocale($locale)
    {
        $this->getAdapter()->setCurrentLocale($locale);
        return $this;
    }

    /**
     * Adds the specified path as a translation directory
     *
     * @param string $path the translation directory
     *
     * @return P\Technical\I18n\Service
     *
     * @throws Exception if an error occured
     */
    public function addRepository($path)
    {
        $this->getAdapter()->checkDirExists($path)
                           ->addRepository($path);
        return $this;
    }
}