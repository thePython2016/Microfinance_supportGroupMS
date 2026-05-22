<?php

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$connection = finance_db_connect();
$result = finance_db_query($connection, 'SELECT username, user_category FROM profile');

foreach ($result as $row) {
    echo $row['username'] . ' => ' . $row['user_category'] . PHP_EOL;
}
