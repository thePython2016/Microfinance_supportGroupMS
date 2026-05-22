<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$sql = file_get_contents(__DIR__ . '/supabase_compat.sql');

if ($sql === false) {
    fwrite(STDERR, "Could not read supabase_compat.sql\n");
    exit(1);
}

foreach (preg_split('/;\s*\n/', $sql) as $statement) {
    $statement = trim($statement);
    if ($statement === '' || str_starts_with($statement, '--')) {
        continue;
    }

    if (finance_db_query($connection, $statement) === false) {
        fwrite(STDERR, finance_db_connect_error() . PHP_EOL);
        fwrite(STDERR, $statement . PHP_EOL);
        exit(1);
    }
}

echo "Supabase compatibility layer installed.\n";
