<?php

header('Content-Type: text/plain');
echo 'PHP version: ' . PHP_VERSION . PHP_EOL;
echo 'SAPI: ' . PHP_SAPI . PHP_EOL;
echo 'php.ini: ' . (php_ini_loaded_file() ?: '(not loaded - extensions missing)') . PHP_EOL;
echo 'extension_dir: ' . ini_get('extension_dir') . PHP_EOL;
echo 'PHPRC env: ' . (getenv('PHPRC') ?: '(not set)') . PHP_EOL;
echo 'pdo_pgsql: ' . (extension_loaded('pdo_pgsql') ? 'yes' : 'no') . PHP_EOL;
echo 'PDO drivers: ' . implode(', ', PDO::getAvailableDrivers()) . PHP_EOL;
echo PHP_EOL;

echo 'Render: ' . (getenv('RENDER') ? 'yes' : 'no') . PHP_EOL;

if (!extension_loaded('pdo_pgsql')) {
    if (getenv('RENDER')) {
        echo "FIX: Redeploy with Dockerfile (pdo_pgsql). Runtime must be Docker, not native PHP." . PHP_EOL;
    } else {
        echo "FIX: Run database\\enable_postgresql_php.bat, restart Apache." . PHP_EOL;
    }
}
