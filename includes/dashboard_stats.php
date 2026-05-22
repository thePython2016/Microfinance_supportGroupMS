<?php

/**
 * Dashboard counters (members, shares, loans). Requires $connection from connectDB.
 */
$currentDate = date('Y');

$selectMembers = finance_db_query($connection, 'SELECT COUNT("mobileNumber") AS Count FROM members');
$members = (int) finance_db_scalar($selectMembers, 'Count', 0);

$selectShares = finance_db_query(
    $connection,
    "SELECT COALESCE(SUM(amount), 0) AS Total FROM shares WHERE EXTRACT(YEAR FROM \"date\")='$currentDate'"
);
$total = finance_db_scalar($selectShares, 'Total', 0);

$selectLoans = finance_db_query(
    $connection,
    "SELECT COALESCE(SUM(amount), 0) AS borrowed FROM loans WHERE EXTRACT(YEAR FROM \"date\")='$currentDate'"
);
$Total = finance_db_scalar($selectLoans, 'borrowed', 0);
