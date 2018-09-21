<?php

/**
 * DATA BASE
 */
use Yajra\Oci8\Oci8Connection;
use Illuminate\Database\Capsule\Manager as Capsule;
use Yajra\Oci8\Connectors\OracleConnector;

$capsule = new Capsule();
$capsule->addConnection($container->get('settings')['db']);
$capsule->bootEloquent();
$capsule->setAsGlobal();
$capsule->getDatabaseManager()->extend('oracle', function ($config) {
    $connector = new OracleConnector();
    $connection = $connector->connect($config);
    $db = new Oci8Connection($connection, $config['database'], $config['prefix']);    
    $db->setDateFormat('YYYY-MM-DD HH24:MI:SS');
    $db->setSessionVars(array('NLS_SORT' => 'WEST_EUROPEAN'));
    return $db;
});

if($container->get('settings')['debug']){
    $capsule::connection()->enableQueryLog();
}