<?php
/**
 * Resultset for F_Technical_Database_Service
 *
 * array[<nameTestFunction>] = json result
 *
 *  @return array
 */
return array(
    'testFetchAllWithNoParamSuccess'               => '[{"id":"1","name":"astroboy","type":"mechanical","year":"1952"},{"id":"2","name":"goldorak","type":"mechanical","year":"1976"}]',
    'testFetchAllWithOneParamSuccess'              => '[{"id":"1","name":"astroboy","type":"mechanical","year":"1952"},{"id":"2","name":"goldorak","type":"mechanical","year":"1976"}]',
    'testFetchAllWithManyParamsSuccess'            => '[{"id":"2","name":"goldorak","type":"mechanical","year":"1976"}]',
    'testFetchAllByKeyWithSuccess'                 => '[{"id":"2","name":"goldorak","type":"mechanical","year":"1976"}]',
    'testInsertWithSuccessReturnId'                => '[{"id":"1","name":"astroboy","type":"mechanical","year":"1952"},{"id":"2","name":"goldorak","type":"mechanical","year":"1976"},{"id":"3","name":"Steve Ostin","type":"android","year":"1984"},{"id":"4","name":"Marauder","type":"biomecha","year":"2052"}]',
    'testUpdateWithSuccessReturnTrue'              => '[{"id":"1","name":"astroboy","type":"mechanical","year":"1952"},{"id":"2","name":"Marauder","type":"biomecha","year":"2052"},{"id":"3","name":"Steve Ostin","type":"android","year":"1984"}]',
    'testUpdateWithNoWhereClauseSuccessReturnTrue' => '[{"id":"1","name":"Marauder","type":"biomecha","year":"2052"},{"id":"2","name":"Marauder","type":"biomecha","year":"2052"},{"id":"3","name":"Marauder","type":"biomecha","year":"2052"}]',
    'testDeleteWithSuccessReturnTrue'              => '[{"id":"1","name":"astroboy","type":"mechanical","year":"1952"},{"id":"3","name":"Steve Ostin","type":"android","year":"1984"}]',
    'testDeleteWithNoWhereSuccessReturnTrue'       => '[]',
);