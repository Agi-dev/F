<?php
/**
 * Show var content
 *
 * @param mixed $v var to watch
 * @param bool  $exit exit(true by default)
 * @param bool  $dump add var type (false by default)
 */
function fdbg($v, $exit = true, $dump = false)
{
	$calledFrom = debug_backtrace();
	$calledFrom = "\n=== DEBUG FROM ". substr($calledFrom[0]['file'], 1) .' (line ' . $calledFrom[0]['line'].")\n\n";
	if (true === $dump) {
		//header('Content-Type: text/html');
		echo $calledFrom;
		var_dump($v);
	} else {
		//header('Content-Type: text/plain');
		echo $calledFrom;
		print_r($v);
	}

	echo "\n\n=== FIN DEBUG \n";

	if (true === $exit) {
		exit(-1);
	}
}

/**
 * Remove all accentuation from a string
 *
 * @param string $str      string
 * @return the string without all the accents
 */
function stripAccent($str)
{
	$str = htmlentities($str, ENT_NOQUOTES, 'utf-8');

	$str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
	$str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
	return $str;
}