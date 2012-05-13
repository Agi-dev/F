<?php
/**
 * F\Technical\I18n\Service is a class to handle i18n operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François Schneider <fschneider.ext@orange.com>
 * @package   F\Technical\I18n
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\I18n;

/**
 *
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\I18n\Service is a class to handle i18n operations.
 *
 * @category F
 * @package F\Technical\I18n
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */
class Service extends \F\Technical\Base\Service
{

    /**
     * Returns the singleton of this service
     *
     * @return F\Technical\I18n\Service
     */
    public static function singleton ()
    {
        return parent::singleton();
    }

    /**
     * Returns an instance of this service
     *
     * @return F\Technical\I18n\Service
     */
    public static function factory ($adapter = null)
    {
        return parent::factory($adapter);
    }

    /**
     * Returns the underlying adapter
     *
     * @return F\Technical\I18n\Adapter\Definition
     */
    public function getAdapter ()
    {
        return parent::getAdapter();
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
    public function translate ($key, $args=null)
    {
		$i18n = $this->getAdapter()->getI18nTranslation();
		
		if (true === isset($i18n[$key])) {
		
			if (null !== $args && false === is_array($args) ) {
				$args = array($args);
			}
			
			$message = $i18n[$key];
			
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
		
		return str_replace('.', ' ', $key);
    }

    /**
     * Ajoute un fichier de traduction
     *
     * @param mixed $filePath
     *
     * @throws \RuntimeException
     */
    public function addI18nFile ($filePath)
    {
        $this->getAdapter()->checkFileExists($filePath);
    	$i18n = $this->getAdapter()->getI18nContent($filePath);
        $this->getAdapter()->addI18nTranslation($i18n);

        return $this;
    }
}