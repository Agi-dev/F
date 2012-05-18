<?php
/**
 * 'badformat'         => 412,
 * 'conflict'          => 409,
 * 'dbfailure'         => 511,
 * 'denied'            => 403,
 * 'empty'             => 412,
 * 'error'             => 500,
 * 'missing'           => 400,
 * 'notauthentified'   => 401,
 * 'notempty'          => 412,
 * 'notfound'          => 404,
 * 'notyetimplemented' => 400,
 * 'unexpected'        => 500,
 * 'unknown'           => 404,
 * 'toshort'           => 412,
 * 'notconnected'      => 503,
 * 'alreadyexist'      => 409
 */


return array(
	// badformat
	'filesystem.resource.badformat' => "la resource fichier est null ou incorrect",

	// error
	'classloader.register.error' => "impossible de charger l'autoload",

	// notfound
	'filesystem.file.notfound' => "le fichier '%{1}' n'existe pas",
    'filesystem.dir.notfound'  => "le répertoire '%{1}' n'existe pas",

	// param.missing
	'param.missing'           => "'%{1}' paramètre manquant",
	'class.attribut.missing'  => "l'attribue de class %{1} n'est pas initialisé",

	// notconnected
	'database.notconnected'  => "aucune connection à une base de données",

    // unknown
    'config.key.unknown' => "clef de registre '%{1}' inconnue",
);
