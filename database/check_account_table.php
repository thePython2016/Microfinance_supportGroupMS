<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();

foreach (['account', 'profile'] as $table) {
    echo "=== $table ===\n";
    $result = finance_db_query($connection, "SELECT * FROM $table LIMIT 10");
    if ($result instanceof FinanceDbResult) {
        foreach($result ?: [] as $row) {
            echo json_encode($row, JSON_UNESCAPED_UNICODE) . "\n";
        }
    } else {
        echo 'Error: ' . finance_db_connect_error() . "\n";
    }
}
