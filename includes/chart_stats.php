<?php

require_once __DIR__ . '/connectDB.php';

/**
 * Monthly chart series for loans and shares. Requires $connection from connectDB.
 */
$months = [];
$amount = [];
$shareMonths = [];
$shareAmount = [];

// 1. Fetch Loans Data
$selectLoans = finance_db_query(
    $connection,
    'SELECT TRIM(TO_CHAR("date", \'Month\')) AS months, COALESCE(SUM(amount), 0) AS total FROM loans
     GROUP BY TRIM(TO_CHAR("date", \'Month\')), EXTRACT(MONTH FROM "date")
     ORDER BY EXTRACT(MONTH FROM "date")'
);

if ($selectLoans instanceof FinanceDbResult) {
    foreach($selectLoans ?: [] as $loans) {
        // Enforce lowercase keys to eliminate database driver naming discrepancies
        $loansLower = array_change_key_case($loans, CASE_LOWER);
        $months[] = !empty($loansLower['months']) ? trim($loansLower['months']) : 'Unknown';
        $amount[] = floatval($loansLower['total'] ?? 0);
    }
}

// 2. Fetch Shares Data
$selectShares = finance_db_query(
    $connection,
    'SELECT TRIM(TO_CHAR("date", \'Month\')) AS months, COALESCE(SUM(amount), 0) AS total FROM shares
     GROUP BY TRIM(TO_CHAR("date", \'Month\')), EXTRACT(MONTH FROM "date")
     ORDER BY EXTRACT(MONTH FROM "date")'
);

if ($selectShares instanceof FinanceDbResult) {
    foreach($selectShares ?: [] as $shares) {
        // Enforce lowercase keys to eliminate database driver naming discrepancies
        $sharesLower = array_change_key_case($shares, CASE_LOWER);
        $shareMonths[] = !empty($sharesLower['months']) ? trim($sharesLower['months']) : 'Unknown';
        $shareAmount[] = floatval($sharesLower['total'] ?? 0);
    }
}

// Fallbacks: Stops Chart.js errors if the database return tables are entirely empty
if (empty($months)) { $months = ['No Data Available']; $amount = [0]; }
if (empty($shareMonths)) { $shareMonths = ['No Data Available']; $shareAmount = [0]; }