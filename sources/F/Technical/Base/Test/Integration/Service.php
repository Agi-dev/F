<?php
/**
 * asm - F_Technical_Abstract_Test_Integration_Service
 *
 * @author François Schneider <fschneider.ext@orange-ftgroup.com>
 */


namespace F\Technical\Base\Test\Integration;

/**
 * @see F/Technical/Base/Test/Base.php
 */
require_once 'F/Technical/Base/Test/Base.php';

/**
 * Abstract integration Service Test
 *
 * @category   F
 * @package    F_Technical
 */
abstract class Service
	 extends \F\Technical\Base\Test\Base
{
	/**
	 * @var mixed
	 */
	protected $_service;

	/**
	 *  chemin vers les jeux d'essai
	 *
	 * @var string
	 */
	protected $_datasetPath = null;

	public function getServicePath()
	{
		return preg_replace('|Test$|', '', get_class($this));
	}
	/**
	 * Returns the class of the service to unit-test
	 *
	 * @return string
	 */
	public function getServiceClass()
	{
		$path = dirname(str_replace('\\', '/', $this->getServicePath()));
		return str_replace('/','\\',$path) . '\\Service';
	}

	/**
	 * Returns the tested service instance.
	 *
	 * @return mixed
	 */
	public function s()
	{
		return $this->_service;
	}

	/**
	 * Returns the unit-tested service
	 *
	 * @return mixed
	 */
	public function getService()
	{
		return $this->_service;
	}

	/**
	 * set DatasetPath
	 *
	 * @param unknown_type $path
	 */
	protected function setDataSetPath($path)
	{
		$this->_datasetPath = $path;
		return $this;
	}

	/**
	 * get datasetPath
	 *
	 * @return string
	 *
	 */
	protected function getDataSetPath()
	{
 	    if ( false === isset($this->_datasetPath) ) {
 	    	$r = \F\Technical\Registry\Service::singleton();
 		    if ( true === $r->hasProperty('dataSetPath') ) {
 		        $this->_datasetPath = $r->getProperty('dataSetPath');
 		        return $this->_datasetPath;
 		    }
 	    }
	    if ( false === isset($this->_datasetPath) ) {
	        $defaultPath = realpath(dirname(__FILE__)
		                              . '/../../../../../../tests/integration/php/dataset');
		    if ( false !== $defaultPath && true === file_exists($defaultPath) ) {
		        $this->_datasetPath = $defaultPath;
		    } else {
		        throw new \RuntimeException('no dataset path set');
		    }

		}
		return $this->_datasetPath;

	}

	/**
	 * get Resultset
	 *
	 * @param string $key
	 * @param string $resultFile
	 *
	 * @return array
	 */
	protected function getResultSet($key, $resultFile = null)
	{
		if ( null === $resultFile ) {
			$class = get_class($this->_service);
			$f = explode('\\', $class);
			$resultFile = $f[1]. '_' . $f[2] . '.php';
		}
		$rs = include ($this->getDataSetPath() . '/resultset/' . $resultFile);
		return $rs[$key];
	}

	/**
	 * Set up data set context for test
	 *
	 * @param string $sqlFile
	 *
	 * @return \F\Technical\Base\Test\Integration_Service
	 */
	protected function setUpDataSet($sqlFile)
	{
		// On met en place notre jeu de test
		$sqlFile = $this->getDataSetPath() . '/' . $sqlFile;
		\F\Technical\Database\Service::singleton()->execScriptFile($sqlFile);
		return $this;
	}

	/**
	 * Compare actual to resultset
	 * @param mixed $actual
	 */
	public function assertEqualsResultSet($actual)
	{
		$tmp = debug_backtrace();
		return $this->assertEquals($this->getResultSet($tmp[1]['function']),
									 json_encode($actual));
	}
	
	/**
	 * clean content folder in dataset
	 * @param unknown $folder
	 * @return \F\Technical\Base\Test\Integration\Service
	 */
	protected function cleanFolderInDataset($folder)
	{
		$p = $this->getDataSetPath().'/' . $folder;
		$this->_deleteDir($p, false);
		return $this;
	}
	
	/**
	 * recursice delete content dir
	 * @param string $dir
	 * @param bool $deleteMe
	 * @return \F\Technical\Base\Test\Integration\Service
	 */
	private function _deleteDir ($dir, $deleteMe=true)
	{
		$listFiles = array_diff(scandir($dir), array('.','..'));
		foreach ($listFiles as $file) {
			$toDelete = $dir . '/' .$file;
			if ( true === is_dir($toDelete) ) {
				$this->_deleteDir($toDelete);
			} else {
				unlink($toDelete);
			}
		}
		if ( true === $deleteMe ) {
			rmdir($dir);
		}
		return $this;
	}
}