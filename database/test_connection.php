<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$result = finance_db_query($connection, 'SELECT version() AS version');

if ($result instanceof FinanceDbResult && $result->num_rows > 0) {
    $row = $result->current();
    echo 'PostgreSQL connection OK' . PHP_EOL;
    echo $row['version'] . PHP_EOL;
    exit(0);
}

echo 'Connection failed: ' . finance_db_connect_error() . PHP_EOL;
exit(1);
