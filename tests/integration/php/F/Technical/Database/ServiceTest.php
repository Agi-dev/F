<?php
/**
 * F\Technical\Database\Service is
 * a class to handle database operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Laurent Labrunie <llabrunie.ext@orange.com>
 * @package    F\Technical\Database\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Database;


/**
 * @see tests/integration/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @see F/Technical/Base/Test/Integration/Service.php
 */
require_once 'F/Technical/Base/Test/Integration/Service.php';

/**
 * F\Technical\Database\Service is
 * a class to handle database operations.
 *
 * @category F
 * @package F\Technical\Database
 * @copyright  Copyright (c) 2012 <COPYRIGHT>
 * @license    <LICENSE>
 * @version    Release: @package_version@
 * @since      Class available since Release 0.0.1
 */
class ServiceTest
    extends \F\Technical\Base\Test\Integration\Service
{
    /**
     * @return F\Technical\Database\Service
     */
    public function s()
    {
        return parent::s();
    }

    public function connectDatabase($init=true)
    {
    	$config = \F\Technical\Registry\Service::singleton()->getProperty('bdd');
        $this->s()->connect($config);
        if ( true === $init ) {
            $this->s()->execScriptFile($this->getDataSetPath() . '/TestDatabaseService.sql');
        }
    }

    /**
     * connect
     */
    public function testConnectWithNoConfigFoundThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', "clef de registre '_databaseConfig' inconnue" );
        $this->s()->connect();
    }

    public function testConnectWithConfigParamSuccess()
    {
        $config = \F\Technical\Registry\Service::singleton()->getProperty('bdd');
    	$this->assertInstanceOfService($this->s()->connect($config));
    }

    public function testConnectWithoutConfigParamGetDefaultSuccess()
    {
        $config = \F\Technical\Registry\Service::singleton()->getProperty('bdd');
        \F\Technical\Registry\Service::singleton()->setProperty('_databaseConfig', $config);
    	$this->assertInstanceOfService($this->s()->connect());
    }

    /**
     * checkConnection
     */
    public function testCheckConnectionWithNoConnectionThrowRuntimeException()
    {
    	$this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
    	$this->s()->checkConnection();
    }

    function testCheckConnectionWithSuccess()
    {
        $this->connectDatabase(false);
        $this->assertInstanceOfService($this->s()->checkConnection());
    }

    /**
     * execScriptFile
     */
    public function testExecScriptFileWithNoDatabaseConnexionThrowException()
    {
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->execScriptFile($this->getDataSetPath() . '/Database/SqlFileButNoDbConnection.sql');
    }

    public function testExecScriptFileWithFileNotFoundThrowException()
    {
        $this->connectDatabase(false);
    	$this->setExpectedException('RuntimeException', "le fichier 'FileNotFound' n'existe pas");
        $this->s()->execScriptFile('FileNotFound');
    }

    public function testExecScriptFileWithSuccess()
    {
    	$this->connectDatabase(false);
    	$actual = $this->s()->execScriptFile($this->getDataSetPath() . '/TestDatabaseExecScript.sql');
    	$this->assertInstanceOfService($actual);
    }

    /**
     * fetchAll
     */
    public function testFetchAllWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->fetchAll('requete', array('knownData'));
  }

    public function testFetchAllWithNoDataReturnedReturnEmptyArray()
    {
        $this->connectDatabase();
        $sql = 'SELECT * FROM robots WHERE year > 2999';
    	$actual = $this->s()->fetchAll($sql);
    	$this->assertEquals(array(), $actual);
    }

    public function testFetchAllWithNoParamSuccess()
    {
        $this->connectDatabase();
        $sql = "SELECT * FROM robots WHERE `type` = 'mechanical'";
        $actual = $this->s()->fetchAll($sql);
        $this->assertEquals($this->getResultSet('Technical_Database.php', __FUNCTION__),
                            json_encode($actual));
    }

    public function testFetchAllWithOneParamSuccess()
    {
        $this->connectDatabase();
    	$sql = "SELECT * FROM robots WHERE `type` = %{1}";
    	$actual = $this->s()->fetchAll($sql, 'mechanical');
    	$this->assertEquals($this->getResultSet('Technical_Database.php', __FUNCTION__),
    	                    json_encode($actual));
    }

    public function testFetchAllWithManyParamsSuccess()
    {
        $this->connectDatabase();
        $sql = "SELECT * FROM robots WHERE `type` = %{1} AND year > %{2}";
        $actual = $this->s()->fetchAll($sql, array('mechanical', 1954));
        $this->assertEquals($this->getResultSet('Technical_Database.php', __FUNCTION__),
                            json_encode($actual));
    }


}