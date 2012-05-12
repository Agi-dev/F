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
	'notafile.badformat'  => "'%{1}' n'est pas un fichier",

	// error
	'classloader.register.error' => "Impossible de charger l'autoload",
	
	// notfound
	'file.notfound' => "le fichier '%{1}' n'existe pas",

	// param.missing
	'param.missing'  => "'%{1}' paramètre manquant",
	'class.attribut.missing'  => "L'attribue de class %{1} n'est pas initialisé",

	// notconnected
	'database.notconnected'  => "aucune connection à une base de données",
);
