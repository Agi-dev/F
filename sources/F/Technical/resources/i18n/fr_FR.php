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
 * 'notsupported'      => 400,
 * 'notyetimplemented' => 400,
 * 'unexpected'        => 500,
 * 'unknown'           => 404,
 * 'toshort'           => 412,
 * 'notconnected'      => 503,
 * 'alreadyexist'      => 409
 */


return array(
    /**
     * Exception
     */
	// badformat
	'filesystem.resource.badformat' => "la resource fichier est null ou incorrect",

	// error
	'classloader.register.error' => "impossible de charger l'autoload",

	// notfound
	'filesystem.file.notfound' => "le fichier '%{1}' n'existe pas",
    'filesystem.dir.notfound'  => "le répertoire '%{1}' n'existe pas",
    'table.id.notfound'         => "l'id '%{1}' de la table '%{2}' n'existe pas",

    'flash.priority.notfound'  => "la priorité de flash '%{1}' est inconnue",

	// param.missing
	'param.missing'           => "'%{1}' paramètre manquant",
	'class.attribut.missing'  => "l'attribue de class %{1} n'est pas initialisé",

	// notconnected
	'database.notconnected'  => "aucune connection à une base de données",

	// notsupported
	'restful.httpmethod.notsupported' => "HTTP method '%{1}' not supported",

    // unknown
    'config.key.unknown'           => "clef de registre '%{1}' inconnue",
    'database.queries.key.unknown' => "clef de requête sql '%{1}' inconnue",

    /**
     * Trace
     */

    // database
    'database.fetchall.query' => "%{1}",
    'database.sql.query'      => "%{1} : %{2}",
);
