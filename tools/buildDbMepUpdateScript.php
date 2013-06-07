<?php
/**
 * une moulinette vite fait pour générer le script SQL pour MEP
 */
// set_include_path(
// 		"..\asm\sources"
// 		. PATH_SEPARATOR .  get_include_path()
// );
// $_SERVER['CLIENTNAME']='Console';
// // functions utiles
// include_once 'Asm/Technical/functions.php';


$repository= '../database';

if ( false === is_dir($repository) ) {
    die("\n!! Repository des scripts database introuvable, veuillez executer le script a la racine de kcp\n");
}

$buildDir = '../build';
if ( false === is_dir($buildDir)) {
	if ( false === mkdir ($buildDir) ) {
		die("\n!!impossible de creer le repertoire " . $buildDir );
	}
}

$currentRevision = prompt('Saisir le numero de revision courante en production (voir dans la table configs la valeur db.version)', '0');

// on récupère les numéros de révision
$excludedFiles = array ('.', '..', '.svn');
$dirs = listFiles($repository, $excludedFiles);
$updatedRevision = $currentRevision;

/**
 * On récupère la liste de fichiers depuis la révision courante
 */
foreach( $dirs as $file) {
    if (false === is_numeric($file)
    		|| false === is_dir($repository . '/' . $file)) {
    	continue;
    }

    // on se postionne sur la bonne révision
    $revision = (int) $file;
    if ($revision <= $currentRevision) {
    	$updatedRevision = $revision;
    	continue;
    }

    $updatedRevision = $revision;
    $revisionDir = $repository . '/' . $file;
    $files = listFiles($revisionDir, $excludedFiles);

    foreach ($files as $upgradeFile) {

    	$pPos = strrpos($upgradeFile, '.');

    	if (false === $pPos) {
    		continue;
    	}

    	$extension = substr($upgradeFile, $pPos+1);
    	$realFile  = $revisionDir . '/' . $upgradeFile;
    	$nameWithoutExtension = substr($upgradeFile, 0, $pPos);

    	//asm_dbg($upgradeFile . "\n" . $extension . "\n" . $realFile  . "\n" . $nameWithoutExtension );

    	if (3 > substr_count($nameWithoutExtension, '_')) {
    		// skipping badly formatted name
    		continue;
    	}

    	list($num, $target, $type, $name) = explode(
    			'_',
    			$nameWithoutExtension,
    			4);

    	if (false === in_array($target, array('all', 'prod'))) {
    		// skipping file for other environments
    		continue;
    	}

    	if (false === isset($items[$revision])) {
    		$items[$revision] = array();
    	}
    	$items[$revision][] = $realFile;
    }

}

/**
 * on génère le script
 */

$sql = '';

foreach ($items as $revision => $files) {
	$sql .= '-- #### REVISION ' . $revision . " ############\n\n";
	foreach ($files as $file) {
		if (true === is_array($file)) {
			$sql .= '-- ' . strtoupper($file['type']) . ' : ' . $file['file'] . "\n\n";
			continue;
		}
		$sql .= '-- '
		. $file
		. "\n\n"
		. trim(file_get_contents($file))
		. ";\n\n";
	}
	$sql .= "\n";
}

$r = array_keys($items);
$last = count($r)-1;

// On ajoute la ligne qui  permet de connaître la version de la base de données
$sql .= '-- #### UPDATE db.version to ' . $r[$last] . " ############\n\n";
$sql .= "UPDATE `configs` SET `value` = '".$r[$last]."' WHERE `configs`.`name` = 'db.version';\n\n";
$sql .= "COMMIT;\n";

$filename = $buildDir . '/update_bdd_from_'.$r[0].'_to_'.$r[$last].'.sql';

if ( true === file_exists($filename) ) {
    unlink($filename);
}
file_put_contents($filename, $sql);


echo "\n !! SUCCESS !!\n\nLe script de mise a jour '" . basename($filename) . "' a ete depose dans " . $buildDir . "\n";
echo "\nMerci d'avoir utilise " . basename(__FILE__) . " en esperant vous revoir bientot sur nos lignes\n";

/**
 * Fonctions
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