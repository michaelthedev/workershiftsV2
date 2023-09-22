<?php

// Constants
define("BASE_PATH", dirname(__FILE__, 2));

const ROUTES_PATH = BASE_PATH . '/routes';
const CONFIG_PATH = BASE_PATH . '/config';

// Include the composer autoloader
require BASE_PATH.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    $dotenv->load();
}
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);

if (config('app.redis.enabled')) {
    $dotenv->required(['REDIS_URL']);
}
