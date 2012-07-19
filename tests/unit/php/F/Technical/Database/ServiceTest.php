<?php
/**
 * F\Technical\Database\Service is
 * a class to handle database operations.
 *
 * <LICENSETXT>
 *
 * @category  F
 * @author    Pascal Renaut <prenaut.ext@orange.com>
 * @package    F\Technical\Database\Adapter
 * @copyright Copyright (c) 2012 <COPYRIGHT>
 * @license   <LICENSE>
 * @version   $Id: $
 */

namespace F\Technical\Database;

/**
 * @see tests/unit/php/bootstrap.php
 */
require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @see F/Technical/Base/Test/Service.php
 */
require_once 'F/Technical/Base/Test/Service.php';

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
extends \F\Technical\Base\Test\Service
{
	/**
	 * @return F\Technical\Database\Service
	 */
	public function s()
	{
		return parent::s();
	}
	/**
	 * @return F\Technical\Database\Adapter\Mock
	 */
    public function m()
	{
		return parent::m();
	}

	public function mockGetConnectionSuccess()
	{
	    $this->mock('isConnected', true);
	}

	/**
     * fetchAll
     */
	public function testFetchAllWithNoDataReturned()
	{
	    $this->mockGetConnectionSuccess();
	    $this->mock('fetchAll', array(array()));
	    $actual = $this->s()->fetchAll('requete', array('unKnownData'));
	    $this->assertEquals(array(array()), $actual);
	}

    public function testFetchAllWithSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('fetchAll', array(array('knownData')));
        $actual = $this->s()->fetchAll('requete %{1}', array('knownData'));
        $this->assertEquals(array(array('knownData')), $actual);
    }

    public function testFetchAllWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->mock('isConnected', false);
        $this->mock('fetchAll');
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->fetchAll('requete', array('knownData'));
    }

    /**
     * isConnected
     */
    public function testIsConnectedWithSuccess()
    {
        $this->mock('isConnected', true);
        $actual=$this->s()->isConnected();
        $this->assertEquals(true, $actual);
    }

    public function testIsConnectedWithNoSuccess()
    {
        $this->mock('isConnected', false);
        $actual=$this->s()->isConnected();
        $this->assertEquals(false, $actual);
    }

    /**
     * execScriptFile
     */
    public function testExecScriptFileWithFileNotFoundThrowException()
    {
    	$this->mock('isConnected', true);
    	$this->mock('getFileContent', new \RuntimeException('file not found'));


    	$this->setExpectedException('RuntimeException', 'file not found');
    	$this->s()->execScriptFile('FileNotFound');
    }

    public function testExecScriptFileWithNoDatabaseConnexionThrowException()
    {
    	$this->mock('isConnected', false);
    	$this->mock('getFileContent', "une requetes;\nrequetes 2;\n");

    	$this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
    	$this->s()->execScriptFile('SqlFileButNoDbConnection');
    }

    public function testExecScriptFileWithSuccess()
    {
    	$sql=<<<EOF
--
-- Contenu de la table `Country`
--
TRUNCATE `langkeyword`;

# un commentaire
INSERT INTO `contractlinespend` (`idContractLineSpend`, `originalCurrencyContractLineSpend`, `originalAmountContractLineSpend`, `euroAmountContractLineSpend`, `dateContractLineSpend`, `idContractEntity`, `idContractLine`, `idSpendType`, `insertionDate`, `lastModificationDate`, `isSavingFormulaBase`, `isCancelled`) VALUES
(100, 'eur', 1000, 1000, '2011-09-01', '0050', 10, '1', '2011-09-07', '2011-09-07', 0, 0),
(300, 'eur', 10, 10, '2011-09-01', '0400', 10, '--', '2011-09-07', '2011-09-07', 1, 0),
(700, 'eur', 3000, 3000, '2011-09-01', '0312', 30, '#', '2011-09-07', '2011-09-07', 0, 0);
EOF;
    	$this->mockGetConnectionSuccess();
    	$this->mock('getFileContent', $sql);
    	$this->mock('executeDirectQuery');
    	$this->mock('executeDirectQuery');

    	$res = $this->s()->execScriptFile('SqlFile');


    	$this->assertTrue($res instanceof \F\Technical\Database\Service);
    	$this->assertEquals( array ("TRUNCATE `langkeyword`"),
    			$this->m()->getCallArgs('executeDirectQuery'));
    	$this->assertEquals( array ("INSERT INTO `contractlinespend` (`idContractLineSpend`, `originalCurrencyContractLineSpend`, `originalAmountContractLineSpend`, `euroAmountContractLineSpend`, `dateContractLineSpend`, `idContractEntity`, `idContractLine`, `idSpendType`, `insertionDate`, `lastModificationDate`, `isSavingFormulaBase`, `isCancelled`) VALUES (100, 'eur', 1000, 1000, '2011-09-01', '0050', 10, '1', '2011-09-07', '2011-09-07', 0, 0), (300, 'eur', 10, 10, '2011-09-01', '0400', 10, '--', '2011-09-07', '2011-09-07', 1, 0), (700, 'eur', 3000, 3000, '2011-09-01', '0312', 30, '#', '2011-09-07', '2011-09-07', 0, 0);"),
    			$this->m()->getCallArgs('executeDirectQuery', 1));
    }

    /**
     * connect
     */
    public function testConnectWithConfigParamSuccess()
    {
        $this->mock('connect', 'connection');
        $this->mock('isConnected', false);
        $this->assertInstanceOfService( $this->s()->connect('uneconfig'));
        $this->assertEquals(array('uneconfig'), $this->m()->getCallArgs('connect'));
    }

    public function testConnectWithoutConfigParamGetDefaultSuccess()
    {
        $this->mock('isConnected', false);
    	$this->mock('getConnectConfig', 'uneconfig');
        $this->mock('connect', 'connection');
        $this->assertInstanceOfService( $this->s()->connect());
        $this->assertEquals(array('uneconfig'), $this->m()->getCallArgs('connect'));
    }

    /**
     * checkConnection
     */
    function testCheckConnectionWithNoConnectionThrowRuntimeException()
    {
        $this->mock('isConnected', false);
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->checkConnection();
    }

    function testCheckConnectionWithSuccess()
    {
        $this->mockGetConnectionSuccess();
        $actual = $this->s()->checkConnection();
        $expected = get_class($this->s());
        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * getLevelTransaction
     */
    public function testGetLevelTransactionWithSuccess()
    {
        $this->assertEquals(0, $this->s()->getTransactionLevel());
    }

    /**
     * beginTransaction
     */
    public function testBeginTransactionWithSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
        $actual = $this->s()->beginTransaction();
        $this->assertInstanceOfService( $actual);
    }

    public function testBeginTransactionWithMultiBeginTransactionGetTransactionLevelSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->assertEquals(3, $this->s()->getTransactionLevel());
    }

    /**
     * rollbackTransaction
     */
    public function testRollbackTransactionWithSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('rollbackTransaction');
        $actual = $this->s()->rollbackTransaction();
        $this->assertInstanceOfService( $actual);
    }

    public function testRollbackTransactionAfterMultiBeginTransactionNotRollbackSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
        // comme il ne doit pas y avoir d'appel à rollback on ne le mock pas
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->rollbackTransaction();
        $this->s()->rollbackTransaction();
        $this->assertEquals(1, $this->s()->getTransactionLevel());
    }

    public function testRollbackTransactionAfterSeveralBeginTransactionAndRollbackAsManySuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
        $this->mock('rollbackTransaction');
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->rollbackTransaction();
        $this->s()->rollbackTransaction();
        $actual = $this->s()->rollbackTransaction();
        $this->assertInstanceOfService( $actual);
        $this->assertEquals(0, $this->s()->getTransactionLevel());
    }

    public function testRollbackTransactionAfterSeveralBeginTransactionAndMoreRollbackSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
    	$this->mock('rollbackTransaction');
    	$this->s()->beginTransaction();
    	$this->s()->beginTransaction();
    	$this->s()->beginTransaction();
    	$this->s()->rollbackTransaction();
    	$this->s()->rollbackTransaction();
    	$this->s()->rollbackTransaction();
    	$actual = $this->s()->rollbackTransaction();
    	$this->assertInstanceOfService( $actual);
    	$this->assertEquals(0, $this->s()->getTransactionLevel());
    }

    /**
     * commitTransaction
     */
    public function testCommitTransactionWithSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('commitTransaction');
        $actual = $this->s()->commitTransaction();
        $this->assertInstanceOfService( $actual);
    }

    public function testCommitTransactionAfterMultiBeginTransactionNotCommitSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
        // comme il ne doit pas y avoir d'appel à rollback on ne le mock pas
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->commitTransaction();
        $this->s()->commitTransaction();
        $this->assertEquals(1, $this->s()->getTransactionLevel());
    }

    public function testCommitTransactionAfterSeveralBeginTransactionAndCommitAsManySuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
        $this->mock('commitTransaction');
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->beginTransaction();
        $this->s()->commitTransaction();
        $this->s()->commitTransaction();
        $actual = $this->s()->commitTransaction();
        $this->assertInstanceOfService( $actual);
        $this->assertEquals(0, $this->s()->getTransactionLevel());
    }

    public function testCommitTransactionAfterSeveralBeginTransactionAndMoreCommitSuccess()
    {
        $this->mockGetConnectionSuccess();
        $this->mock('beginTransaction');
    	$this->mock('commitTransaction');
    	$this->s()->beginTransaction();
    	$this->s()->beginTransaction();
    	$this->s()->beginTransaction();
    	$this->s()->commitTransaction();
    	$this->s()->commitTransaction();
    	$this->s()->commitTransaction();
    	$actual = $this->s()->commitTransaction();
    	$this->assertInstanceOfService( $actual);
    	$this->assertEquals(0, $this->s()->getTransactionLevel());
    }

    /**
     * prepare
     */
    public function testPrepareWithNoParamSuccess()
    {
        $actual = $this->s()->prepare('requete without param');
        $this->assertEquals("requete without param", $actual);
    }
    public function testPrepareWithParamSuccess()
    {
        $actual = $this->s()->prepare('requete %{0} param', 'avec');
        $this->assertEquals("requete 'avec' param", $actual);
    }
    public function testPrepareWithMultiTypeParamsSuccess()
    {
    	$actual = $this->s()->prepare('param %{int} is int, param %{string} is string, param %{float} is float, ' .
    	          'param %{date} is date', array('int' => 1, 'string' => 'une chaine', 'float' => 1.24, 'date' => '2012-06-01'));
    	$this->assertEquals("param 1 is int, param 'une chaine' is string, param 1.240000 is float" .
    	", param '2012-06-01' is date", $actual);
    }

    /**
     * fetchAllByKey
     */
    public function testFetchAllByKeyWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->mock('includeQueriesFile', array('requete' => ''));
    	$this->mock('isConnected', false);
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->fetchAllByKey('requete', array('knownData'));
    }

    public function testFetchAllByKeyWithUnknownKeyThrowRuntimeException()
    {
    	$this->mock('isConnected', true);
    	$this->mock('includeQueriesFile', array());
    	$this->setExpectedException('RuntimeException', "clef de requête sql 'query' inconnue");
    	$this->s()->fetchAllByKey('unknown.query');
    }

    public function testFetchAllByKeyWithSuccess()
    {
        $this->mock('includeQueriesFile', array('requete' => "une requete sql avec une data =%{unedata}"));
    	$this->mockGetConnectionSuccess();
        $this->mock('fetchAll', array(array('knownData')));
        $actual = $this->s()->fetchAllByKey('requete', array('unedata' => 'theData'));
        $this->assertEquals(array("une requete sql avec une data ='theData'"), $this->m()->getCallArgs('fetchAll'));
    }

    /**
     * setQueriesPath
     */
    public function testSetQueriesPathWithDirNotExistThrowRuntimeException()
    {
    	$this->mock('checkDirExists', new \RuntimeException('dir not exist'));
    	$this->setExpectedException('RuntimeException', 'dir not exist');
    	$this->s()->setQueriesPath('notExist');
    }

    public function testSetQueriesPathWithSuccess()
    {
    	$this->mock('checkDirExists');
    	$this->mock('setQueriesPath', $this->s()->getAdapter());
    	$this->assertInstanceOfService($this->s()->setQueriesPath('unchemin'));
    }

    /**
     * insert
     */

    public function testInsertWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->mock('isConnected', false);
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->insert(array('un champs' => 'une valeur'), 'une table');
    }

    public function testInsertWithSuccessReturnId()
    {
        $this->mock('isConnected', true);
        $this->mock('executeDirectQuery');
        $this->mock('getLastInsertId', 'newId');

        $actual = $this->s()->insert('une table', array('un champs' => 'une valeur', 'un autre' => 10));
        $this->assertEquals('newId', $actual);
        $this->assertEquals(array("INSERT INTO `une table` (`un champs`, `un autre`) VALUES ('une valeur', 10)"),
                            $this->m()->getCallArgs('executeDirectQuery'));
    }

    /**
     * update
     */

    public function testUpdateWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->mock('isConnected', false);
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->update('une table', array('un champs' => 'une valeur'));
    }

    public function testUpdateWithSuccess()
    {
        $this->mock('isConnected', true);
        $this->mock('executeDirectQuery');
        $actual = $this->s()->update('une table', array('un champs' => 'une valeur', 'un autre' => 10),
                                        array('clause where id = %{id} OR name = %{name}',
                                              array('id' => 10, 'name' => 'the name')));
        $this->assertEquals(array("UPDATE `une table` SET `un champs` = 'une valeur', `un autre` = 10 WHERE clause where id = 10 OR name = 'the name'"),
                            $this->m()->getCallArgs('executeDirectQuery'));

    }

    public function testUpdateWithNoWhereClauseSuccess()
    {
        $this->mock('isConnected', true);
        $this->mock('executeDirectQuery');
        $actual = $this->s()->update('une table', array('un champs' => 'une valeur', 'un autre' => 10));
        $this->assertEquals(array("UPDATE `une table` SET `un champs` = 'une valeur', `un autre` = 10"),
                            $this->m()->getCallArgs('executeDirectQuery'));
    }

    public function testUpdateWithNoParamInWhereClauseSuccess()
    {
        $this->mock('isConnected', true);
        $this->mock('executeDirectQuery', true);
        $actual = $this->s()->update('une table', array('un champs' => 'une valeur'),
                                        array("clause where id = 10"));
        $this->assertEquals(array("UPDATE `une table` SET `un champs` = 'une valeur' WHERE clause where id = 10"),
                            $this->m()->getCallArgs('executeDirectQuery'));

    }

    /**
     * delete
     */
    public function testDeleteWithNoDatabaseConnectedThrowRuntimeException()
    {
        $this->mock('isConnected', false);
        $this->setExpectedException('RuntimeException', 'aucune connection à une base de données', 503);
        $this->s()->delete('unetable', 'clausewhere');
    }
    public function testDeleteWithSuccess()
    {
        $this->mock('isConnected', true);
        $this->mock('executeDirectQuery');
        $actual=$this->s()->delete('une table', array('clause where id = %{id} OR name = %{name}',
                                                array('id' => 10, 'name' => 'the name')));
        $this->assertEquals(array("DELETE FROM `une table` WHERE clause where id = 10 OR name = 'the name'"),
                            $this->m()->getCallArgs('executeDirectQuery'));
    }

    public function testDeleteWithNoWhereSuccess()
    {
        $this->mock('isConnected', true);
        $this->mock('executeDirectQuery');
        $actual=$this->s()->delete('une table');
        $this->assertEquals(array("DELETE FROM `une table`"),
                            $this->m()->getCallArgs('executeDirectQuery'));
    }
}