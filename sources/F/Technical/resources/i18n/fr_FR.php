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
    'excel.badformat' => "le fichier '%{1}' n'est pas un fichier excel",
    'excel.resource.badformat' => "la ressource excel est null ou incorrect",
    'filesystem.resource.badformat' => "la resource fichier est null ou incorrect",
    'mail.badformat' => "Le courriel %{2}:'%{1}' semble être invalide",

    // dbfailure
    'sql.insert.dbfailure' => "echec insertion en base de données : '%{1}'",
    'sql.update.dbfailure' => "echec modification en base de données : '%{1}'",
    'sql.delete.dbfailure' => "echec suppression dans la base de données : '%{1}'",

    //denied
    'filesystem.delete.filename.denied' => "le fichier '%{1}' ne peut être supprimé car vous n'avez pas les droits ou le fichier est ouvert",

    // error
    'classloader.register.error' => "impossible de charger l'autoload",

    // missing
    'mail.body.missing' => "Impossible d'envoyer un mail sans corps",
    'mail.object.missing' => "Impossible d'envoyer un mail sans objet",

    // notconnected
    'database.notconnected' => "aucune connection à une base de données",

    // notfound
    'filesystem.file.notfound' => "le fichier '%{1}' n'existe pas",
    'filesystem.dir.notfound' => "le répertoire '%{1}' n'existe pas",
    'filesystem.mime.notfound' => "le mime type pour le fichier '%{1}' est inconnu",
    'mail.att.notfound' => "Le fichier joint '%{1}' n'existe pas",
    'flash.priority.notfound' => "la priorité de flash '%{1}' est inconnue",
    'session.name.notfound' => "Variable de session '%{1}' inconnue",
    'table.id.notfound' => "l'id '%{1}' de la table '%{2}' n'existe pas",

    // notsupported
    'restful.httpmethod.notsupported' => "HTTP method '%{1}' not supported",

    // param.missing
    'param.missing' => "'%{1}' paramètre manquant",
    'class.attribut.missing' => "l'attribue de class %{1} n'est pas initialisé",

    // unexpected
    'mail.from.unexpected' => "",

    // unknown
    'config.key.unknown' => "clef de registre '%{1}' inconnue",
    'database.queries.key.unknown' => "clef de requête sql '%{1}' inconnue",

    /**
     * Trace
     */

    // database
    'database.fetchall.query' => "%{1}",
    'database.sql.query' => "%{1} : %{2}",
);
