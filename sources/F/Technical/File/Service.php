<?php
/**
 * F\Technical\File\Service is a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François <francoisschneider@neuf.fr>
 * @package   F\Technical\File
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\File;

/**
 * @see F/Technical/Abstract/Service.php
 */
require_once 'F/Technical/Base/Service.php';

/**
 * F\Technical\File\Service is a class to handle file operations.
 *
 * @category F
 * @package F\Technical\File
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
	 * @return F\Technical\File\Service
	 */
	public static function singleton()
	{
		return parent::singleton();
	}
	/**
	 * Returns an instance of this service
	 *
	 * @return F\Technical\File\Service
	 */
	public static function factory($adapter = null)
	{
		return parent::factory($adapter);
	}
	/**
	 * Returns the underlying adapter
	 *
	 * @return F\Technical\File\Adapter\Definition
	 */
	public function getAdapter()
	{
		return parent::getAdapter();
	}
}