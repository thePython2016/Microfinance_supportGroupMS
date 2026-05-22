<?php

/**
 * One-time helper: hash any plain-text passwords still stored in profile.
 * Run locally or once on Render: php database/migrate_profile_passwords.php
 */

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';
require_once dirname(__DIR__) . '/includes/auth.php';

$connection = finance_db_connect();
$result = finance_db_query($connection, 'SELECT username, password FROM profile');

if (!($result instanceof FinanceDbResult)) {
    fwrite(STDERR, 'Could not read profile table: ' . finance_db_connect_error() . PHP_EOL);
    exit(1);
}

$updated = 0;
$skipped = 0;

foreach($result ?: [] as $row) {
    $username = (string) ($row['username'] ?? '');
    $stored = (string) ($row['password'] ?? '');

    if ($username === '' || finance_password_is_hashed($stored)) {
        $skipped++;
        continue;
    }

    $hashEsc = finance_db_escape($connection, finance_password_hash($stored));
    $usernameEsc = finance_db_escape($connection, $username);

    if (finance_db_query($connection, "UPDATE profile SET password='$hashEsc' WHERE username='$usernameEsc'") !== false) {
        $updated++;
        echo "Hashed password for: $username" . PHP_EOL;
    }
}

echo "Done. Updated: $updated, already hashed or empty: $skipped" . PHP_EOL;
