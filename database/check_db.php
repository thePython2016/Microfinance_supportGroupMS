<?php

header('Content-Type: text/plain');

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

try {
    $connection = finance_db_connect();
    $result = finance_db_query($connection, 'SELECT 1 AS ok');
    if ($result instanceof FinanceDbResult && $result->num_rows > 0) {
        echo "Database connection OK\n";
        exit(0);
    }
    echo "Query failed\n";
    exit(1);
} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}
