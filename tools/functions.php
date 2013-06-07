<?php
// @codeCoverageIgnoreStart
/**
 * Show var content
 *
 * @param mixed $v var to watch
 * @param bool  $exit exit(true by default)
 * @param bool  $dump add var type (false by default)
 */
function _dbg($v, $exit = true, $dump = false)
{
	
    $calledFrom = debug_backtrace();
	$calledFrom = "\n=== DEBUG FROM ". substr($calledFrom[0]['file'], 1) .' (line ' . $calledFrom[0]['line'].")\n\n";
	if (true === $dump) {
	    if ( false === isset($_SERVER['CLIENTNAME']) || $_SERVER['CLIENTNAME'] != 'Console') {
		    header('Content-Type: text/html');
	    }
		echo $calledFrom;
		var_dump($v);
	} else {
		if ( false === isset($_SERVER['CLIENTNAME']) || $_SERVER['CLIENTNAME'] != 'Console') {
	        header('Content-Type: text/plain');
		}
		echo $calledFrom;
		print_r($v);
	}

	echo "\n\n=== FIN DEBUG \n";

	if (true === $exit) {
		exit(-1);
	}
}

function buildClonedTree($source, &$vars, $root = null, $options = null)
{
	if (false === is_array($options)) {
		$options = array();
	}

	if (false === isset($options['variable.prefix'])) {
		$options['variable.prefix'] = 'pm.';
	}

	if (false === is_array($source)) {
		$source = listFilesContents($source);
	}

	$files = array();

	ksort($source);

	foreach($source as $file => $content) {
		$destFile   = searchReplaceProperties($file, $vars, $options);
		if ('%.php' === substr($destFile, - strlen('%.php'))) {
			$destFile = substr($destFile, 0, strlen($destFile) - strlen('%.php'));
			$content  = searchReplaceProperties(runScript($content, $vars), $vars, $options);
		}elseif ('%unparsed' === substr($destFile, strlen($destFile) - strlen('%unparsed'))) {
			$destFile = substr($destFile, 0, strlen($destFile) - strlen('%unparsed'));
		}else{
			$content = searchReplaceProperties($content, $vars, $options);
		}
		$files[$destFile] = $content;
	}

	return $files;
}

function searchReplaceProperties($content, &$vars, $options = null)
{
	$foundVars = searchProperties($content, $options);
	foreach($foundVars as $k => $v){
		if (false === isset($vars[$k])){
			$vars[$k] = prompt($k, isset($options[$k . '.default']) ? $options[$k . '.default'] : null);
		}
	}
	return replaceProperties($content, $vars, $options);
}

function runScript($script, $vars = null)
{
	try {
		ob_start();
		php_eval('?>' . $script, $vars);
		$content = ob_get_contents();
		ob_end_clean();
	} catch (\Exception $e) {
		die('runscript.error ' . $script .' ' . $e->getMessage());
	}

	return $content;
}

function listFilesContents($source, $root = null)
{
	if ( false === is_dir($source) ) {
		die($source . " n'est pas un répertoire");
	}
	$ignores = array(
			'.', '..', '.git', '.bzr', '.svn', 'CVS',
	);
	$files = array();
	foreach(listFiles($source, $ignores) as $file) {
		if (true === in_array($file, $ignores)) {
			continue;
		}
		$realSourceFile = $source . '/' . $file;
		$realDestFile   = ($root ? $root . '/' : '') . $file;

		if (true === is_dir($realSourceFile)) {
			$files = array_merge($files, listFilesContents($realSourceFile, $realDestFile));
		} else {
			$files[$realDestFile] = myReadFile($realSourceFile);
		}
	}

	return $files;
}

/**
 * Décrit l'arbre
 * @param unknown $source
 * @param unknown $vars
 * @param string $options
 * @param string $root
 * @return Ambigous <string, multitype:multitype: >
 */
function describeTree($source, $vars, $options = null, $root = null)
{
	$isRoot = false;
	if (null === $root) {
		$root = $source;
		$isRoot = true;
	}
	$model = array('vars' => array(), 'files' => array(), 'directories' => array());
	
	if (false === is_array($options)) {
		$options = array();
	}
	
	$ignores = array(
			'.', '..', '.git', '.bzr', '.svn', 'CVS',
	);
	
	foreach(listFiles($source, $ignores) as $file) {
		if (true === in_array($file, $ignores)) {
			continue;
		}
		$realSourceFile = $source . '/' . $file;
	
		searchNotReplaceProperties($file, $model['vars'], $options);
		if (true === is_dir($realSourceFile)) {
			$model['directories'][] = $realSourceFile;
			$tmpModel = describeTree($realSourceFile, $vars, $options, $root);
			$model['vars'] = array_merge($model['vars'], $tmpModel['vars']);
			$model['files'] = array_merge($model['files'], $tmpModel['files']);
			$model['directories'] = array_merge($model['directories'], $tmpModel['directories']);
		} else {
			$model['files'][] = $realSourceFile;
			if ('%.php' === substr($realSourceFile, strlen($realSourceFile) - strlen('%.php'))) {
				searchNotReplaceProperties(renderView($realSourceFile, $vars, true), $model['vars'], $options);
			}else{
				searchNotReplaceProperties(myReadFile($realSourceFile), $model['vars'], $options);
			}
		}
	}

	if (true === $isRoot) {
		foreach($model['vars'] as $k => $v) {
			if (true === isset($vars[$k])) {
				$model['vars'][$k] = $vars[$k];
			}
		}
		foreach($model['files'] as $k => $v) {
			$model['files'][$k] = substr($v, strlen($root) + 1);
		}
		foreach($model['directories'] as $k => $v) {
			$model['directories'][$k] = substr($v, strlen($root) + 1);
		}
	}
	return $model;

}

function writeTree($files, $destination)
{
	createDirectory($destination);

	foreach($files as $fileName => $fileContent) {
		if (0 === strpos($fileName, '%resources')) {
			continue;
		}
		$realDestFile = $destination . '/' . $fileName;
		if (true === $fileContent) {
			if (false === is_dir($realDestFile)) {
				createDirectory($realDestFile);
			}
		} else {
			$parentDir = dirname($fileName);
			if ('.' !== $parentDir && './' !== $parentDir) {
				$realParentDir = $destination . '/' . $parentDir;
				if (false === is_dir($realParentDir)) {
					createDirectory($realParentDir);
				}
			}
			if (true === is_file($realDestFile)) {
				$res =  prompt('Fichier ' . $realDestFile . ' deja existant, le remplacer ?', 'n');
				if ('n' === $res) {
					continue;
				}
			}
			writeFile($realDestFile, $fileContent);
		}
	}

	return $files;
}

/**
 * Sets the content of the specified file.
 *
 * @param string|array $path    the file path
 * @param mixed        $content the file content
 *
 * @return int|array
 *
 * @throws Exception if an error occured
 */
function writeFile($path, $content)
{
	$stringMode = false;

	if (false === is_array($path)) {
		$stringMode = true;
		$path       = array($path);
	}

	checkArrayEmpty($path, 'file');
	 
	$written   = array();
	$expecting = strlen($content);

	foreach($path as $i => $p) {
		createDirectory(dirname($p));


		$written[$i] = file_put_contents($p, $content, null);
	}

	if (true === $stringMode) {
		return $written[0];
	}

	return $written;
}

/**
 * Creates a new directory and its parent directories.
 *
 * @param string|array $path the directory path
 * @param hexa   $mask the optional creation mask
 *
 * @return P\Technical\Filesystem\Service
 *
 * @throws Exception if an error occured
 */
function createDirectory($path, $mask = 0777, $options = null)
{
	if (null === $mask) {
		$mask = 0777;
	}

	if (false === is_array($path)) {
		$path = array($path);
	}

	if (null === $options) {
		$options = array();
	}
	foreach($path as $p) {
		if ('/' === $p || '.' === $p) {
			continue;
		}

		if (true === is_dir($p)) {
			return 1;
		}

		createDirectory(dirname($p), $mask, array_merge($options, array('child' => true)));

		mkdir($p, $mask);

		
	}
	return 1;
}

/**
 * 
 * @param unknown $file
 * @param string $vars
 * @param string $return
 * @return Ambigous <boolean, mixed>
 */
function renderView($file, $vars = null, $return = true)
{
	if (false === is_bool($return)) {
		$return = true;
	}

	if (true === $return) {
		obStart();
	}

	if (false === is_array($vars)) {
		$vars = array();
	}

	$content = includeFile($file,$vars);

	if (true === $return) {
		$content = obEndClean();
	}

	return $content;
}


/**
 * 
 * @param unknown $content
 * @param unknown $vars
 * @param string $options
 * @return Ambigous <string, unknown, mixed, multitype:, multitype:\P\Technical\Filesystem\Adapter\mixed >
 */
function searchNotReplaceProperties($content, &$vars, $options = null)
{
	if (false === is_array($options)) {
		$options = array();
	}
	$foundVars = searchProperties($content, $options);
	$vars = array_merge($vars, $foundVars);
	return replaceProperties($content, $vars, array_merge($options, array('replace-unknown' => false)));
}

/**
 * 
 * @param unknown $string
 * @param string $options
 * @return multitype:|multitype:Ambigous <string, multitype:>
 */
function searchProperties($string, $options = null)
{
	$prefix = '';

	if (true === isset($options['variable.prefix'])) {
		$prefix = str_replace(array('.'), array('\\.'), $options['variable.prefix']);
	}

	$matches=null;
	$vars=array();
	if (0 >= preg_match_all('/\%\{' . $prefix . '([^\}]+)\}/', $string, $matches)) return array();

	for($i=0;$i<count($matches[0]);$i++){
		if (false !== strpos($matches[1][$i], '@')) {
			list($func, $args) = explode('@', $matches[1][$i], 2);
			switch(strtolower(trim($func))) {
				case 'include':
				case 'percentage':
				case 'packagify':
				case 'date':
				case 'ucfirst':
				case 'lcfirst':
				case 'ucwords':
				case 'strtoupper':
				case 'strtolower':
				case 'trim':
				case 'ltrim':
				case 'rtrim':
				case 'crc32':
				case 'crypt':
				case 'md5':
				case 'sha1':
				case 'str_word_count':
				case 'strlen':
					break;
				default:$func = null;break;
			}
			if (null !== $func) {
				$matches2 = null;
				if (0 < preg_match("/^['\"](.*)['\"]$/", $args, $matches2)) $args = null;
			}
			$value=$args;
		}else{
			$value=$matches[1][$i];
		}
		$default = '';
		if (false!==strpos($value, '|')) {
			list($value,$default) = explode('|', $value, 2);
		}
		if (null !== $value) {
			$vars[$value]=$default;
		}
	}
	return $vars;
}

/**
 * 
 * @param unknown $string
 * @param unknown $vars
 * @param string $options
 * @return unknown|Ambigous <string, multitype:, multitype:string >|string|mixed
 */
function replaceProperties($string, $vars, $options = null)
{
	$prefix = '';

	if (true === isset($options['variable.prefix'])) {
		$prefix = str_replace(array('.'), array('\\.'), $options['variable.prefix']);
	}

	if (false === is_array($options)) {
		$options = array();
	}
	$matches = null;
	if (0 >= preg_match_all('/\%\{' . $prefix . '([^\}]+)\}/', $string, $matches)) return $string;
	for($i=0;$i<count($matches[0]);$i++) {
		$value = $matches[0][$i];
		if (false !== strpos($matches[1][$i], '@')) {
			list($func, $args) = explode('@', $matches[1][$i]);
			switch(strtolower(trim($func))) {
				case 'include':
					$func = function ($path = null) {
						return myReadFile($path);
					};
					break;
				case 'percentage':
					$func = function ($value = null) {
						return round($value * 100, 2) . '%';
					};
					break;
				case 'packagify':
					$func = function($value = '') {
						return str_replace(array('~~~~', ' '), array(' ', '/'), ucwords(str_replace(array(' ', '_', '\\', '-'), array('~~~~', ' ', ' ', ' '), $value)));
					};
					break;
				case 'path': $value = $vars['root']; $func = null; break;
				case 'date':
				case 'ucfirst':
				case 'lcfirst':
				case 'ucwords':
				case 'strtoupper':
				case 'strtolower':
				case 'trim':
				case 'ltrim':
				case 'rtrim':
				case 'crc32':
				case 'crypt':
				case 'md5':
				case 'sha1':
				case 'str_word_count':
				case 'strlen':
					break;
				default:$func = null;break;
			}
			$default = isset($options['replace-unknown']) && false === $options['replace-unknown'] ? $matches[0][$i] : '';
			if (false !==strpos($args, '|')) {
				list($args, $default) = explode('|', $args, 2);
			}

			if (null !== $func) {
				$matches2 = null;
				if (0 < preg_match("/^['\"](.*)['\"]$/", $args, $matches2)) $args = $matches2[1];
				elseif (true === isset($vars[$args])) $args = $vars[$args];
				else $args = $default;

				if (is_callable($func)) $value = $func($args);
			} else {
				$matches2 = null;
				if (0 < preg_match("/^['\"](.*)['\"]$/", $args, $matches2)) $args = $matches2[1];
				elseif (true === isset($vars[$args])) $args = $vars[$args];
				else $args = $default;
				$value = $args;
			}
		} else {
			$default = isset($options['replace-unknown']) && false === $options['replace-unknown'] ? $matches[0][$i] : '';
			if (false !==strpos($matches[1][$i], '|')) {
				list($matches[1][$i], $default) = explode('|', $matches[1][$i], 2);
			}
			if (isset($vars[$matches[1][$i]])) $value = $vars[$matches[1][$i]];
			else $value = $default;
		}
		$string = str_replace($matches[0][$i], $value, $string);
	}
	return $string;
}

/**
 * Returns the content of the specified file.
 *
 * @param string|array $path the file path
 *
 * @return string|array the file content
 *
 * @throws Exception if an error occured
 */
function myReadFile($path)
{
	$stringMode = false;

	if (false === is_array($path)) {
		$stringMode = true;
		$path       = array($path);
	}

	checkArrayEmpty($path, 'file');

	$content = array();

	foreach($path as $i => $p) {
		$content[$i] = file_get_contents($p);
	}

	if (true === $stringMode) {
		return $content[0];
	}

	return $content;
}

/**
 * 
 * @param unknown $path
 * @param unknown $exclusions
 * @return multitype:
 */
function listFiles($path, $exclusions = array()) {
	$files = @scandir($path);

	if (true === is_array ( $exclusions ) && 0 < count ( $exclusions )) {
		$files = array_merge(array(), array_diff ( $files, $exclusions ));
		if (false === is_array ( $files )) {
			$files = array ();
		}
	}
	natsort($files);
	return $files;
}

/**
 * Starts output buffering.
 *
 * @return bool always true
 *
 * @throws Exception if an error occured
 */
function obStart()
{
	$err1   = error_get_last();
	$result = @ob_start();
	$err    = error_get_last();

	if (false === $result && serialize($err1) !== serialize($err)) {
		throw new \RuntimeException($err['message'], 1000 + $err['type']);
	}

	return true === $result;
}
/**
 * Stops and cleans output buffering.
 *
 * @return bool always true
 *
 * @throws Exception if an error occured
 */
function obEndClean()
{
	$err1   = error_get_last();
	$result = @ob_end_clean();
	$err    = error_get_last();

	if (false === $result && serialize($err1) !== serialize($err)) {
		throw new \RuntimeException($err['message'], 1000 + $err['type']);
	}

	return true === $result;
}

/**
 * Includes the specified file.
 *
 * @param string $path the file path
 * @param array  $vars the variables
 * @param string $type include_once ? require ?
 *
 * @return mixed
 */
function includeFile($path, $vars=null)
{
	$____path = $path;

	if (true === is_array($vars)) {
		extract($vars);
	}

	$____result = null;

	$oldER = ini_get('error_reporting');
	$oldDE = ini_get('display_errors');
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');
	$____result = include $____path;
	ini_set('error_reporting', $oldER);
	ini_set('display_errors', $oldDE);

	return $____result;
}

/**
 * 
 * @param unknown $array
 * @param unknown $type
 * @throws \RuntimeException
 * @return NULL
 */
function checkArrayEmpty($array, $type)
{
	if (0 === count($array)) {
		throw new \RuntimeException('tableau vide');
	}

	return 1;
}

/**
 * 
 * @param unknown $prompt
 * @param string $default
 * @return string
 */
function prompt($prompt, $default = '') {
	while(!isset($input) ) {
		echo $prompt . ('' !== $default?' ['.$default.']':'') . ' : ';
		$input = strtolower(trim(fgets(STDIN)));
		if(empty($input) && !empty($default)) {
			$input = $default;
		}
	}
	return $input;
}

// @codeCoverageIgnoreEnd