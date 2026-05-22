<?php

/**
 * Reset account table logins (bcrypt). Run after deploy if login fails.
 * php database/reset_account_logins.php
 */

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';
require_once dirname(__DIR__) . '/includes/auth.php';

$connection = finance_db_connect();

$users = [
    ['admin', 'admin123', 1],
    ['staff', 'staff123', 2],
];

foreach ($users as [$username, $plainPassword, $level]) {
    $usernameEsc = finance_db_escape($connection, $username);
    $hashEsc = finance_db_escape($connection, finance_password_hash($plainPassword));

    finance_db_query(
        $connection,
        "INSERT INTO account (username, password, level)
         VALUES ('$usernameEsc', '$hashEsc', $level)
         ON CONFLICT (username) DO UPDATE
         SET password = EXCLUDED.password, level = EXCLUDED.level"
    );

    echo "OK: $username / $plainPassword (level $level)\n";
}

echo "Account logins reset.\n";
