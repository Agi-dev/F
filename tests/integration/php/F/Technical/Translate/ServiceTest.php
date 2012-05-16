<?php
/**
 * F\Technical\Translate\Service is
 * a class to handle translate operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    fschneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Translate\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Translate;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\Translate\Service is
 * a class to handle translate operations.
 *
 * @category F
 * @package F\Technical\Translate
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\Translate\Service
     */
    public function s()
    {
        return parent::s();
    }

    /**
     * translate
     */
    public function testTranslateWithNoTranslateFileSuccess()
    {
        $this->assertEquals('key notexist',$this->s()->translate('key.notexist'));
    }

    public function testTranslateWithDefaultMessageSuccess()
    {
        $this->s()->setCurrentLocale('fr_FR');
        $this->assertEquals("une erreur inconnu s'est produite", $this->s()->translate('error'));
    }

    public function testTranslateWithManyTranslateFileGetMessageForTwoLanguagesSuccess()
    {
        $this->s()->setCurrentLocale('fr_FR');
        $this->s()->addRepository($this->getDataSetPath() );
        $this->assertEquals('un message en français', $this->s()->translate('keymany'));
        $this->s()->setCurrentLocale('en_US');
        $this->assertEquals('One message un english', $this->s()->translate('keymany'));
    }
}