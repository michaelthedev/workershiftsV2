<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Constants
define("BASE_PATH", dirname(__FILE__, 2));
const ROUTES_PATH = BASE_PATH . '/routes';
const CONFIG_PATH = BASE_PATH . '/config';

// Include the composer autoloader
require BASE_PATH.'/vendor/autoload.php';

// Setup database
/*$capsule = new Capsule;
$capsule->addConnection([
    'host' => config('database.host'),
    'driver' => config('database.driver'),
    'charset' => config('database.charset'),
    'database' => config('database.name'),
    'username' => config('database.username'),
    'password' => config('database.password'),
    'collation' => config('database.collation'),
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();*/