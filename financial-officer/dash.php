<?php
$currentDate = date('Y');

$selectMembers = finance_db_query($connection, 'select count("mobileNumber") as Count from members');
$members = (int) finance_db_scalar($selectMembers, 'Count', 0);

$selectShares = finance_db_query(
    $connection,
    "select sum(amount) as Total from shares where EXTRACT(YEAR FROM \"date\")='$currentDate'"
);
$total = finance_db_scalar($selectShares, 'Total', 0);

$selectLoans = finance_db_query(
    $connection,
    "select sum(amount) as borrowed from loans where EXTRACT(YEAR FROM \"date\")='$currentDate'"
);
$Total = finance_db_scalar($selectLoans, 'borrowed', 0);
