<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

require 'connectDB.php';

$phone = trim($_GET['phone'] ?? '');
if ($phone === '') {
    echo json_encode(['success' => false, 'error' => 'Missing phone parameter']);
    exit;
}

$phoneEsc = finance_db_escape($connection, $phone);

$shareQuery = "
    SELECT TO_CHAR(s.share_date, 'YYYY-MM') AS month_key,
           COALESCE(SUM(s.amount), 0) AS total
    FROM shares s
    JOIN members m ON m.id = s.member_id
    WHERE m.mobilenumber = '$phoneEsc'
    GROUP BY TO_CHAR(s.share_date, 'YYYY-MM')
    ORDER BY MIN(s.share_date) ASC
";
$loanQuery = "
    SELECT TO_CHAR(l.loan_date, 'YYYY-MM') AS month_key,
           COALESCE(SUM(l.amount), 0) AS total
    FROM loans l
    LEFT JOIN members m ON m.mobilenumber = l.mobilenumber
    WHERE l.mobilenumber = '$phoneEsc'
    GROUP BY TO_CHAR(l.loan_date, 'YYYY-MM')
    ORDER BY MIN(l.loan_date) ASC
";
$statusQuery = "
    SELECT COALESCE(status, 'Unknown') AS status, COUNT(*) AS total
    FROM loans
    WHERE mobilenumber = '$phoneEsc'
    GROUP BY status
";

$shareMonths = [];
$shareAmount = [];
$loanMonths = [];
$loanAmount = [];
$activeLoans = 0;
$pendingLoans = 0;
$paidLoans = 0;
$overdueLoans = 0;

$shareResult = finance_db_query($connection, $shareQuery);
foreach ($shareResult ?: [] as $row) {
    $shareMonths[] = date('Y-M', strtotime(($row['month_key'] ?? '') . '-01'));
    $shareAmount[] = (float)($row['total'] ?? 0);
}

$loanResult = finance_db_query($connection, $loanQuery);
foreach ($loanResult ?: [] as $row) {
    $loanMonths[] = date('Y-M', strtotime(($row['month_key'] ?? '') . '-01'));
    $loanAmount[] = (float)($row['total'] ?? 0);
}

$statusResult = finance_db_query($connection, $statusQuery);
foreach ($statusResult ?: [] as $row) {
    $status = strtolower(trim($row['status'] ?? ''));
    $count = (int)($row['total'] ?? 0);
    switch ($status) {
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

if (empty($shareMonths)) {
    $shareMonths = ['No Data Available'];
    $shareAmount = [0];
}

if (empty($loanMonths)) {
    $loanMonths = ['No Data Available'];
    $loanAmount = [0];
}

echo json_encode([
    'success' => true,
    'shareMonths' => $shareMonths,
    'shareAmount' => $shareAmount,
    'loanMonths' => $loanMonths,
    'loanAmount' => $loanAmount,
    'activeLoans' => $activeLoans,
    'pendingLoans' => $pendingLoans,
    'paidLoans' => $paidLoans,
    'overdueLoans' => $overdueLoans,
]);
exit;
