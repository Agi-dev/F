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
     * @return \F\Technical\Database\Service
     */
    public function s()
    {
        return parent::s();
    }

    public function connectDatabase($init=true)
    {
    	$config = \F\Technical\Registry\Service::singleton()->getProperty('bdd');
        $this->s()->connect($config);
        $this->s()->setQueriesPath($this->getDataSetPath());
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
    	$sql = "SELECT * FROM robots WHERE `type` = %{0}";
    	$actual = $this->s()->fetchAll($sql, 'mechanical');
    	$this->assertEquals($this->getResultSet('Technical_Database.php', __FUNCTION__),
    	                    json_encode($actual));
    }

    public function testFetchAllWithManyParamsSuccess()
    {
        $this->connectDatabase();
        $sql = "SELECT * FROM robots WHERE `type` = %{type} AND year > %{annee}";
        $actual = $this->s()->fetchAll($sql, array('type' => 'mechanical', 'annee' => 1954));
        $this->assertEquals($this->getResultSet('Technical_Database.php', __FUNCTION__),
                            json_encode($actual));
    }

    /**
     * setQueriesPath
     */
    public function testSetQueriesPathWithDirNotExistThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', "le répertoire 'notExist' n'existe pas");
        $this->s()->setQueriesPath('notExist');
    }

    public function testSetQueriesPathWithSuccess()
    {
        $this->assertInstanceOfService($this->s()->setQueriesPath($this->getDataSetPath()));
    }

    /**
     * fetchAllByKey
     */
    public function testFetchAllByKeyWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->s()->setQueriesPath($this->getDataSetPath());
    	$this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->fetchAllByKey('TestDatabaseKey.typeByYear');
    }

    public function testFetchAllByKeyWithUnknownKeyThrowRuntimeException()
    {
        $this->connectDatabase();
        $this->setExpectedException('RuntimeException', "clef de requête sql 'unknownquery' inconnue");
        $this->s()->fetchAllByKey('TestDatabaseKey.unknownquery');
    }

    public function testFetchAllByKeyWithSuccess()
    {
        $this->connectDatabase();
        $actual = $this->s()->fetchAllByKey('TestDatabaseKey.typeByYear',
                                                array('type' => 'mechanical', 'annee' => 1954));
        $this->assertEquals($this->getResultSet('Technical_Database.php', __FUNCTION__),
                            json_encode($actual));
    }

    /**
     * insert
     */

    public function testInsertWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->insert(array('un champs' => 'une valeur'), 'une table');
    }

    public function testInsertWithSuccessReturnId()
    {
        $this->connectDatabase();
    	$actual = $this->s()->insert('robots', array('name' => "Marauder", 'type' => "biomecha", 'year' => 2052));
        $this->assertEquals(4, $actual);
        $actual = $this->s()->fetchAll('SELECT * FROM robots');
        $this->assertEqualsResultSet($actual);
    }

    /**
     * update
     */

    public function testUpdateWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->update('une table', array('un champs' => 'une valeur'));
    }

    public function testUpdateWithSuccessReturnTrue()
    {
        $this->connectDatabase();
        $data = array('name' => "Marauder", 'type' => "biomecha", 'year' => 2052);
        $where = array('name = %{name} AND `type` = %{type}', array ('name' => "goldorak", 'type' => "mechanical"));
        $actual = $this->s()->update('robots', $data, $where);
        $this->assertTrue($actual);
        $actual = $this->s()->fetchAll('SELECT * FROM robots');
        $this->assertEqualsResultSet($actual);

    }

    public function testUpdateWithNoWhereClauseSuccessReturnTrue()
    {
        $this->connectDatabase();
        $data = array('name' => "Marauder", 'type' => "biomecha", 'year' => 2052);
        $actual = $this->s()->update('robots', $data);
        $this->assertTrue($actual);
        $actual = $this->s()->fetchAll('SELECT * FROM robots');
        $this->assertEqualsResultSet($actual);
    }


    /**
     * delete
     */
    public function testDeleteWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->delete('unetable', 'clausewhere');
    }

    public function testDeleteWithSuccessReturnTrue()
    {
        $this->connectDatabase();
    	$where = array('name = %{name} AND `type` = %{type}', array ('name' => "goldorak", 'type' => "mechanical"));
    	$actual=$this->s()->delete('robots', $where);
        $this->assertTrue($actual);
        $actual = $this->s()->fetchAll('SELECT * FROM robots');
        $this->assertEqualsResultSet($actual);
    }

    public function testDeleteWithNoWhereSuccessReturnTrue()
    {
        $this->connectDatabase();
        $actual=$this->s()->delete('robots');
        $this->assertTrue($actual);
        $actual = $this->s()->fetchAll('SELECT * FROM robots');
        $this->assertEqualsResultSet($actual);
    }


}