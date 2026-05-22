<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();

$users = [
    ['Administrator', 'admin', 1],
    ['Member', 'member', 2],
    ['Financial', 'financial', 3],
];

foreach ($users as [$username, $password, $category]) {
    $username = finance_db_escape($connection, $username);
    $password = finance_db_escape($connection, $password);
    finance_db_query(
        $connection,
        "INSERT INTO profile (username, password, user_category)
         VALUES ('$username', '$password', $category)
         ON CONFLICT (username) DO NOTHING"
    );
}

echo "Profile users seeded.\n";
