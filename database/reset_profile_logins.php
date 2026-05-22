<?php

/**
 * Reset default finance logins (bcrypt). Safe to run on Render after deploy.
 * php database/reset_profile_logins.php
 */

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';
require_once dirname(__DIR__) . '/includes/auth.php';

$connection = finance_db_connect();

$users = [
    ['Administrator', 'admin', 1],
    ['Member', 'member', 2],
    ['Financial', 'financial', 3],
];

foreach ($users as [$username, $plainPassword, $category]) {
    $usernameEsc = finance_db_escape($connection, $username);
    $hashEsc = finance_db_escape($connection, finance_password_hash($plainPassword));

    finance_db_query(
        $connection,
        "INSERT INTO profile (username, password, user_category)
         VALUES ('$usernameEsc', '$hashEsc', $category)
         ON CONFLICT (username) DO UPDATE
         SET password = EXCLUDED.password, user_category = EXCLUDED.user_category"
    );

    echo "OK: $username / $plainPassword (category $category)\n";
}

echo "Default logins ready.\n";
