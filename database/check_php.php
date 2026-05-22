<?php

header('Content-Type: text/plain');
echo 'PHP version: ' . PHP_VERSION . PHP_EOL;
echo 'php.ini: ' . php_ini_loaded_file() . PHP_EOL;
echo 'pdo_pgsql: ' . (extension_loaded('pdo_pgsql') ? 'yes' : 'no') . PHP_EOL;
echo 'PDO drivers: ' . implode(', ', PDO::getAvailableDrivers()) . PHP_EOL;
