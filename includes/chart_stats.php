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
    "SELECT TO_CHAR(\"loan_date\", 'YYYY-MM') AS month_key, COALESCE(SUM(amount), 0) AS total
     FROM \"loans\"
     GROUP BY TO_CHAR(\"loan_date\", 'YYYY-MM')
     ORDER BY MIN(\"loan_date\") ASC"
);

if ($selectLoans instanceof FinanceDbResult) {
    foreach($selectLoans ?: [] as $loans) {
        $loansLower = array_change_key_case($loans, CASE_LOWER);
        $months[] = !empty($loansLower['month_key']) ? date('Y-M', strtotime($loansLower['month_key'] . '-01')) : 'Unknown';
        $amount[] = floatval($loansLower['total'] ?? 0);
    }
}

// 2. Fetch Shares Data
$selectShares = finance_db_query(
    $connection,
    "SELECT TO_CHAR(\"share_date\", 'YYYY-MM') AS month_key, COALESCE(SUM(amount), 0) AS total
     FROM \"shares\"
     GROUP BY TO_CHAR(\"share_date\", 'YYYY-MM')
     ORDER BY MIN(\"share_date\") ASC"
);

if ($selectShares instanceof FinanceDbResult) {
    foreach($selectShares ?: [] as $shares) {
        $sharesLower = array_change_key_case($shares, CASE_LOWER);
        $shareMonths[] = !empty($sharesLower['month_key']) ? date('Y-M', strtotime($sharesLower['month_key'] . '-01')) : 'Unknown';
        $shareAmount[] = floatval($sharesLower['total'] ?? 0);
    }
}

// 3. Fetch Loan Status Counts for dashboard doughnut chart
$activeLoans = 0;
$paidLoans = 0;
$pendingLoans = 0;
$overdueLoans = 0;

$selectLoanStatus = finance_db_query(
    $connection,
    'SELECT status, COUNT(*) AS count FROM "loans" GROUP BY status'
);

if ($selectLoanStatus instanceof FinanceDbResult) {
    foreach ($selectLoanStatus ?: [] as $statusRow) {
        $statusLower = array_change_key_case($statusRow, CASE_LOWER);
        $statusKey = trim(strtolower($statusLower['status'] ?? ''));
        $count = (int)($statusLower['count'] ?? 0);

        switch ($statusKey) {
            case 'active':
                $activeLoans = $count;
                break;
            case 'pending':
                $pendingLoans = $count;
                break;
            case 'paid':
                $paidLoans = $count;
                break;
            case 'overdue':
                $overdueLoans = $count;
                break;
        }
    }
}

// Fallbacks: Stops Chart.js errors if the database return tables are entirely empty
if (empty($months)) { $months = ['No Data Available']; $amount = [0]; }
if (empty($shareMonths)) { $shareMonths = ['No Data Available']; $shareAmount = [0]; }
