<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();

$profile = finance_db_query(
    $connection,
    "SELECT username, password, user_category FROM profile WHERE username='Administrator'"
);
echo 'profile rows: ' . finance_db_num_rows($profile) . PHP_EOL;

$members = finance_db_query($connection, 'SELECT * FROM members LIMIT 1');
if ($members instanceof FinanceDbResult && $members->num_rows > 0) {
    $row = $members->current();
    echo 'member keys: ' . implode(', ', array_keys($row)) . PHP_EOL;
}

$shares = finance_db_query(
    $connection,
    "SELECT sum(amount) as Total FROM shares WHERE EXTRACT(YEAR FROM share_date)=EXTRACT(YEAR FROM CURRENT_DATE)"
);
if ($shares instanceof FinanceDbResult && $shares->num_rows > 0) {
    echo 'shares total query OK' . PHP_EOL;
}

echo "Done\n";
