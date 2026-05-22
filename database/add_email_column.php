<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$ok = finance_db_query($connection, 'ALTER TABLE members ADD COLUMN IF NOT EXISTS email VARCHAR(120)');

echo $ok === false ? finance_db_connect_error() : 'email column ready';
echo PHP_EOL;
