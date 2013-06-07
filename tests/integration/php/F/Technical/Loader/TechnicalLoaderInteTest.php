<?php
/**
 * F\Technical\Loader\Service is
 * a class to handle loader operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Fran�ois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Loader\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Loader;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';


/**
 * F\Technical\Loader\Service is
 * a class to handle loader operations.
 *
 * @category F
 * @package F\Technical\Loader
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */

class TechnicalLoaderInteTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return \F\Technical\Loader\Service
     */
    public function s()
    {
        return parent::s();
    }
    
    public function testSuccess()
    {
    	$this->assertTrue(true);
    }
}