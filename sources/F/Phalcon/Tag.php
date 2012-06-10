<?php
/**
 * F\Phalcon\Tag is phalconphp helperViews
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package   F\Phalcon\Tage
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Phalcon;

/**
 * F\Phalcon is a class that extends Phalcon_Tag
 *
 * @category F
 * @package F\Technical\Acl
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license <LICENSE>
 * @version Release: @package_version@
 * @since Class available since Release 0.0.1
 */

class Tag extends \Phalcon_Tag
{	
	/**
	 * generate HTML5 flash message if any
	 * 
	 * @return string HTML5
	 */
	static public function flash()
	{
		$view = \Phalcon_Controller_Front::getInstance()->getViewComponent();
		$content = "<h2>Cela marche comme je pensais</h2>";
		$view->setContent($content);
		return $this;
	} 	
}