<?php
/**
 * F\Technical\Trace\Service is
 * a class to handle trace operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Francois Schneider <francoisschneider@neuf.fr>
 * @package    F\Technical\Trace\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Trace;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\Trace\Service is
 * a class to handle trace operations.
 *
 * @category F
 * @package F\Technical\Trace
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\Trace\Service
     */
    public function s()
    {
        return parent::s();
    }
    
    public function setUp()
    {
    	parent::setUp();
    	\F\Technical\i18n\Service::singleton()
    			->addI18nFile($this->getDataSetPath() . '/fr_FR.php');
    }

    /**
     * trace
     */
    public function testTraceWithParamsSuccess()
    {
        $appConfig = array (
            'activated' => 1,
            'file' => dirname(__FILE__)
                . '/TraceWithParamsSuccess',
            'keylevelfile' => $this->getDataSetPath() . '/TraceLevelKeyMessage.ini',
        );
        $this->s()->configure($appConfig);
        $this->s()->trace('test.withparam',
            array('One', 'Two') );
        $this->assertFileExists($appConfig['file']);
        $this->assertStringEndsWith('[INFO] param One and param Two'."\n",
            file_get_contents($appConfig['file']) );
        $this->s()->getAdapter()->closeLog();
        unlink($appConfig['file']);
    }

    public function testTraceWithNoActivationTraceSuccess()
    {
        $appConfig = array (
        	'activated' => 0,
            'file' => dirname(__FILE__) . '/TraceWithNoActivationTraceSuccess'
        );
        $this->s()->configure($appConfig);
        $this->s()->trace('test.with.param.success',
            array('paramètres', 'marchent'));
        $this->assertFileNotExists($appConfig['file']);
    }

    public function testTraceWithNoMessageTraceFileAndNoKeyTraceLevelSuccess()
    {
        $appConfig = array (
            'activated' => 1,
            'file' => dirname(__FILE__)
            . '/TraceWithNoMessageTraceFileAndNoKeyTraceLevel.log'
        );
        $this->s()->configure($appConfig);
        $this->s()->trace('test.with.param.success',
            array('paramètres', 'marchent'));
        $this->assertFileExists($appConfig['file']);
        $this->s()->getAdapter()->closeLog();
        unlink($appConfig['file']);
    }

    public function testTraceWithOnlyWarningMessageFilterSuccess()
    {
        $appConfig = array (
            'activated' => 1,
            'file' => dirname(__FILE__)
            . '/TraceWithOnlyWarningMessageFilterSuccess.log',
            'keylevelfile' => $this->getDataSetPath() . '/TraceLevelKeyMessage.ini',
            'filters' => array(('warning')),
        );

        $this->s()->configure($appConfig);
        $this->s()->trace('test.withparam',
            array('One', 'Two') );
        $this->s()->trace('test.warning');
        $this->s()->trace('test.error');
        $this->assertFileExists($appConfig['file']);
        $this->assertStringEndsWith('[WARNING] ceci est un warning'."\n",
            file_get_contents($appConfig['file']) );
        $this->s()->getAdapter()->closeLog();
        unlink($appConfig['file']);
    }

//     public function testTraceWithTranslationInFrenchSuccess()
//     {
//         $appConfig = array (
//             'activated' => 1,
//             'file' => dirname(__FILE__)
//             . '/testTraceWithTranslationInFrenchSuccess.log',
//             'keylevelfile' => $this->getDataSetPath() . '/TraceLevelKeyMessage.ini',
//         );
//         $this->s()->configure($appConfig);
//         \F\Technical\I18n\Service::singleton()->setCurrentLocale('fr-fr');
//         $this->s()->trace('test.lang');
//         $this->assertFileExists($appConfig['file']);
//         $this->assertStringEndsWith('[INFO] trace en français'."\n",
//             file_get_contents($appConfig['file']) );
//         unlink($appConfig['file']);

//     }

//     public function testTraceWithTranslationInEnglishSuccess()
//     {
//         $appConfig = array (
//             'activated' => 1,
//             'file' => dirname(__FILE__)
//             . '/testTraceWithTranslationInEnglishSuccess.log',
//             'keylevelfile' => $this->getDataSetPath() . '/TraceLevelKeyMessage.ini',
//         );
//         $this->s()->configure($appConfig);
//         \F\Technical\I18n\Service::singleton()->setCurrentLocale('en-us');
//         $this->s()->trace('test.lang');
//         $this->assertFileExists($appConfig['file']);
//         $this->assertStringEndsWith('[INFO] trace in english'."\n",
//             file_get_contents($appConfig['file']) );
//         unlink($appConfig['file']);

//     }
    
}