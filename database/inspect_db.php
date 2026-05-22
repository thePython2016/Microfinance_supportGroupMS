<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$result = finance_db_query($connection, "
    SELECT table_name, column_name, data_type
    FROM information_schema.columns
    WHERE table_schema = 'public'
    ORDER BY table_name, ordinal_position
");

foreach($result ?: [] as $row) {
    echo $row['table_name'] . '.' . $row['column_name'] . ' (' . $row['data_type'] . ')' . PHP_EOL;
}
