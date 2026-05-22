<?php

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
}

echo "Profile users seeded with bcrypt password hashes.\n";
