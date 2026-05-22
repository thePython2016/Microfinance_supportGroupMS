<?php

require_once __DIR__ . '/connectDB.php';

/**
 * Monthly chart series for loans and shares. Requires $connection from connectDB.
 */
$months = [];
$amount = [];
$shareMonths = [];
$shareAmount = [];

$selectLoans = finance_db_query(
    $connection,
    'SELECT TRIM(TO_CHAR("date", \'Month\')) AS months, COALESCE(SUM(amount), 0) AS Total FROM loans
     GROUP BY TRIM(TO_CHAR("date", \'Month\')), EXTRACT(MONTH FROM "date")
     ORDER BY EXTRACT(MONTH FROM "date")'
);

if ($selectLoans instanceof FinanceDbResult) {
    foreach($selectLoans ?: [] as $loans) {
        $months[] = $loans['months'] ?? $loans['Months'] ?? '';
        $amount[] = $loans['Total'] ?? $loans['total'] ?? 0;
    }
}

$selectShares = finance_db_query(
    $connection,
    'SELECT TRIM(TO_CHAR("date", \'Month\')) AS months, COALESCE(SUM(amount), 0) AS Total FROM shares
     GROUP BY TRIM(TO_CHAR("date", \'Month\')), EXTRACT(MONTH FROM "date")
     ORDER BY EXTRACT(MONTH FROM "date")'
);

if ($selectShares instanceof FinanceDbResult) {
    foreach($selectShares ?: [] as $shares) {
        $shareMonths[] = $shares['months'] ?? $shares['Months'] ?? '';
        $shareAmount[] = $shares['Total'] ?? $shares['total'] ?? 0;
    }
}
