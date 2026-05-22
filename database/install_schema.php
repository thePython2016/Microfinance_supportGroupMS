<?php
/**
 * Installs the full database schema + compatibility views.
 * Run once on a fresh database: php database/install_schema.php
 */

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$ok = 0;
$errors = 0;

function run_sql_file(string $path, $connection, int &$ok, int &$errors): void
{
    $sql = file_get_contents($path);
    if ($sql === false) {
        fwrite(STDERR, "Could not read $path\n");
        $errors++;
        return;
    }

    // Split on semicolons that end a statement (skip comment-only chunks)
    $statements = preg_split('/;\s*\n/', $sql);
    foreach($statements ?: [] as $stmt) {
        $stmt = trim($stmt);
        if ($stmt === '' || preg_match('/^--/', $stmt)) {
            continue;
        }
        $result = finance_db_query($connection, $stmt);
        if ($result === false) {
            $errors++;
            fwrite(STDERR, '[ERROR] ' . finance_db_connect_error() . "\n");
            fwrite(STDERR, substr($stmt, 0, 200) . "\n\n");
        } else {
            $ok++;
        }
    }
}

echo "=== Step 1: applying postgres_schema.sql ===\n";
run_sql_file(__DIR__ . '/postgres_schema.sql', $connection, $ok, $errors);

echo "=== Step 2: applying supabase_compat.sql (views) ===\n";
run_sql_file(__DIR__ . '/supabase_compat.sql', $connection, $ok, $errors);

echo "\nDone. Statements OK: $ok, Failed: $errors\n";
exit($errors > 0 ? 1 : 0);
