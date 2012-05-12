<?php
/**
 * F\Technical\File\Service is
 * a class to handle file operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    François <francoisschneider@neuf.fr>
 * @package    F\Technical\File\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\File;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\File\Service is
 * a class to handle file operations.
 *
 * @category F
 * @package F\Technical\File
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\File\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * just for saying there is no test
     */
    public function testToImplement()
    {
    }
}