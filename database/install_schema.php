<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$sql = file_get_contents(__DIR__ . '/postgres_schema.sql');

if ($sql === false) {
    fwrite(STDERR, "Could not read postgres_schema.sql\n");
    exit(1);
}

// Run statement-by-statement (skip comments-only chunks)
$statements = preg_split('/;\s*\n/', $sql);
$ok = 0;
$errors = 0;

foreach ($statements as $statement) {
    $statement = trim($statement);
    if ($statement === '' || str_starts_with($statement, '--')) {
        continue;
    }

    $result = finance_db_query($connection, $statement);
    if ($result === false) {
        $errors++;
        fwrite(STDERR, finance_db_connect_error() . PHP_EOL);
        fwrite(STDERR, substr($statement, 0, 120) . "...\n");
    } else {
        $ok++;
    }
}

echo "Schema install finished. Statements OK: $ok, failed: $errors\n";
exit($errors > 0 ? 1 : 0);
