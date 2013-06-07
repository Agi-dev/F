<?php
// pour debug
$_SERVER['CLIENTNAME'] = 'Console';
include_once('functions.php');

// Récupération du fichier de conf si existant
$conf = __FILE__ . '/conf.php';

// Récupération des paramètres en entrée
$argc = $_SERVER['argc'];
if ( 1 === $argc || $argc > 2 ) {
	die("\nf_tpl <nom template>\n");
}

// Récupération des params de conf si existant
$conf = __DIR__ .'/conf.php';
$vars = array();
$tplDir = '';
if ( true === file_exists($conf) ) {
	$conf = includeFile($conf);
	if ( true === isset($_SERVER['COMPUTERNAME']) ) {
		$vars = $conf[$_SERVER['COMPUTERNAME']];
	}
	if ( true === isset($_SERVER['tplDir']) ) {
		$tplDir .= $conf['tplDir'];
	} else {
		$tplDir = "templates/";
	}
} 

// on ajoute le nom du template passé en paramètre
$tplDir .= $_SERVER['argv'][1];

// Répertoire template existe ?
if ( false === is_dir($tplDir) ) {
	die("Repertoire $tplDir introuvable");
}

// on applique le template en fonction des paramètres
$tree = buildClonedTree($tplDir, $vars);
writeTree($tree, './');
