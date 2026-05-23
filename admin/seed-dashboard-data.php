<?php
/**
 * Comprehensive test data seeder for admin dashboard
 * Populates members, shares, and loans with data across multiple months
 * Run: php admin/seed-dashboard-data.php
 */

require "connectDB.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "═══════════════════════════════════════════════════════════\n";
echo "  DASHBOARD TEST DATA SEEDER\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// 1. CLEAR EXISTING TEST DATA (optional - comment out if you want to keep existing data)
// echo "[CLEARING] Removing existing test data...\n";
// finance_db_query($connection, "DELETE FROM shares WHERE member_id IN (SELECT id FROM members WHERE mobilenumber LIKE '256%')");
// finance_db_query($connection, "DELETE FROM loans WHERE member_id IN (SELECT id FROM members WHERE mobilenumber LIKE '256%')");
// finance_db_query($connection, "DELETE FROM members WHERE mobilenumber LIKE '256%'");

// 2. INSERT MEMBERS
echo "[MEMBERS] Inserting test members...\n";
$members = [
    ['mobile' => '256701234567', 'fname' => 'John', 'lname' => 'Doe', 'nin' => 'UN12345678'],
    ['mobile' => '256702345678', 'fname' => 'Jane', 'lname' => 'Smith', 'nin' => 'UN98765432'],
    ['mobile' => '256703456789', 'fname' => 'Bob', 'lname' => 'Johnson', 'nin' => 'UN11111111'],
    ['mobile' => '256704567890', 'fname' => 'Alice', 'lname' => 'Williams', 'nin' => 'UN22222222'],
    ['mobile' => '256705678901', 'fname' => 'Charlie', 'lname' => 'Brown', 'nin' => 'UN33333333'],
];

$member_ids = [];
foreach ($members as $member) {
    $mobile_esc = finance_db_escape($connection, $member['mobile']);
    $fname_esc = finance_db_escape($connection, $member['fname']);
    $lname_esc = finance_db_escape($connection, $member['lname']);
    $nin_esc = finance_db_escape($connection, $member['nin']);
    
    $sql = "INSERT INTO members (mobilenumber, fname, lname, nin) 
            VALUES ('$mobile_esc', '$fname_esc', '$lname_esc', '$nin_esc')
            ON CONFLICT (mobilenumber) DO NOTHING";
    $result = finance_db_query($connection, $sql);
    if ($result === false) {
        echo "  ✗ Failed to insert {$member['fname']}\n";
    } else {
        echo "  ✓ {$member['fname']} {$member['lname']} ({$member['mobile']})\n";
    }
}

// Fetch inserted member IDs
echo "\n[MEMBERS] Fetching member IDs...\n";
$members_result = finance_db_query($connection, "SELECT id, mobilenumber FROM members WHERE mobilenumber LIKE '256%' ORDER BY id");
foreach ($members_result ?: [] as $row) {
    $member_ids[$row['mobilenumber']] = $row['id'];
    echo "  ✓ ID {$row['id']} → {$row['mobilenumber']}\n";
}

if (count($member_ids) == 0) {
    echo "ERROR: No members found. Aborting.\n";
    exit(1);
}

// 3. INSERT SHARES (distributed across 6 months)
echo "\n[SHARES] Inserting shares data across months...\n";
$shares_data = [
    // January 2026
    ['member_id' => array_values($member_ids)[0], 'amount' => 100000, 'date' => '2026-01-05'],
    ['member_id' => array_values($member_ids)[1], 'amount' => 150000, 'date' => '2026-01-10'],
    ['member_id' => array_values($member_ids)[2], 'amount' => 120000, 'date' => '2026-01-15'],
    
    // February 2026
    ['member_id' => array_values($member_ids)[0], 'amount' => 110000, 'date' => '2026-02-05'],
    ['member_id' => array_values($member_ids)[1], 'amount' => 160000, 'date' => '2026-02-10'],
    ['member_id' => array_values($member_ids)[3], 'amount' => 130000, 'date' => '2026-02-15'],
    
    // March 2026
    ['member_id' => array_values($member_ids)[2], 'amount' => 125000, 'date' => '2026-03-05'],
    ['member_id' => array_values($member_ids)[3], 'amount' => 135000, 'date' => '2026-03-10'],
    ['member_id' => array_values($member_ids)[4], 'amount' => 140000, 'date' => '2026-03-15'],
    
    // April 2026
    ['member_id' => array_values($member_ids)[0], 'amount' => 115000, 'date' => '2026-04-05'],
    ['member_id' => array_values($member_ids)[1], 'amount' => 165000, 'date' => '2026-04-10'],
    ['member_id' => array_values($member_ids)[2], 'amount' => 130000, 'date' => '2026-04-15'],
    
    // May 2026
    ['member_id' => array_values($member_ids)[3], 'amount' => 140000, 'date' => '2026-05-05'],
    ['member_id' => array_values($member_ids)[4], 'amount' => 145000, 'date' => '2026-05-10'],
    ['member_id' => array_values($member_ids)[0], 'amount' => 120000, 'date' => '2026-05-15'],
];

$shares_count = 0;
foreach ($shares_data as $share) {
    $sql = "INSERT INTO shares (member_id, share_date, amount) 
            VALUES ({$share['member_id']}, '{$share['date']}'::DATE, {$share['amount']})";
    $result = finance_db_query($connection, $sql);
    if ($result === false) {
        echo "  ✗ Failed: Member {$share['member_id']}, {$share['amount']} on {$share['date']}\n";
    } else {
        $shares_count++;
        echo "  ✓ Share: {$share['amount']} TZS on {$share['date']} (Member ID {$share['member_id']})\n";
    }
}
echo "  → Total shares inserted: $shares_count\n";

// 4. INSERT LOANS (distributed across 6 months, with multiple statuses)
echo "\n[LOANS] Inserting loans data across months...\n";
$loans_data = [
    // January 2026 - Active loans
    ['member_id' => array_values($member_ids)[0], 'amount' => 500000, 'interest' => 5, 'status' => 'active', 'date' => '2026-01-05'],
    ['member_id' => array_values($member_ids)[1], 'amount' => 750000, 'interest' => 6, 'status' => 'active', 'date' => '2026-01-10'],
    
    // February 2026 - Mix of active and paid
    ['member_id' => array_values($member_ids)[2], 'amount' => 600000, 'interest' => 5.5, 'status' => 'paid', 'date' => '2026-02-05'],
    ['member_id' => array_values($member_ids)[3], 'amount' => 800000, 'interest' => 7, 'status' => 'active', 'date' => '2026-02-10'],
    
    // March 2026 - Pending approvals
    ['member_id' => array_values($member_ids)[4], 'amount' => 1000000, 'interest' => 6.5, 'status' => 'pending', 'date' => '2026-03-05'],
    ['member_id' => array_values($member_ids)[0], 'amount' => 450000, 'interest' => 5, 'status' => 'active', 'date' => '2026-03-10'],
    
    // April 2026 - Overdue loans
    ['member_id' => array_values($member_ids)[1], 'amount' => 700000, 'interest' => 6, 'status' => 'overdue', 'date' => '2026-04-05'],
    ['member_id' => array_values($member_ids)[2], 'amount' => 550000, 'interest' => 5.5, 'status' => 'paid', 'date' => '2026-04-10'],
    
    // May 2026 - Recent loans
    ['member_id' => array_values($member_ids)[3], 'amount' => 650000, 'interest' => 6, 'status' => 'active', 'date' => '2026-05-05'],
    ['member_id' => array_values($member_ids)[4], 'amount' => 900000, 'interest' => 7, 'status' => 'pending', 'date' => '2026-05-10'],
];

$loans_count = 0;
foreach ($loans_data as $loan) {
    $sql = "INSERT INTO loans (member_id, loan_date, amount, interest_rate, status) 
            VALUES ({$loan['member_id']}, '{$loan['date']}'::DATE, {$loan['amount']}, {$loan['interest']}, '{$loan['status']}')";
    $result = finance_db_query($connection, $sql);
    if ($result === false) {
        echo "  ✗ Failed: Member {$loan['member_id']}, {$loan['amount']} on {$loan['date']}\n";
    } else {
        $loans_count++;
        echo "  ✓ Loan: {$loan['amount']} TZS ({$loan['status']}) on {$loan['date']} (Member ID {$loan['member_id']})\n";
    }
}
echo "  → Total loans inserted: $loans_count\n";

// 5. VERIFICATION
echo "\n[VERIFICATION] Database counts...\n";
$verify_members = finance_db_query($connection, "SELECT COUNT(*) as cnt FROM members");
$verify_shares = finance_db_query($connection, "SELECT COUNT(*) as cnt FROM shares");
$verify_loans = finance_db_query($connection, "SELECT COUNT(*) as cnt FROM loans");

foreach ($verify_members ?: [] as $row) {
    echo "  ✓ Total members: " . $row['cnt'] . "\n";
}
foreach ($verify_shares ?: [] as $row) {
    echo "  ✓ Total shares: " . $row['cnt'] . "\n";
}
foreach ($verify_loans ?: [] as $row) {
    echo "  ✓ Total loans: " . $row['cnt'] . "\n";
}

// Show monthly breakdown
echo "\n[MONTHLY BREAKDOWN]\n";
echo "  Shares by month:\n";
$monthly_shares = finance_db_query($connection, "SELECT TO_CHAR(share_date, 'YYYY-MM') AS month, COUNT(*) as cnt, SUM(amount) as total FROM shares GROUP BY TO_CHAR(share_date, 'YYYY-MM') ORDER BY month");
foreach ($monthly_shares ?: [] as $row) {
    $month = $row['month'] ?? $row['MONTH'];
    $cnt = $row['cnt'] ?? $row['CNT'];
    $total = $row['total'] ?? $row['TOTAL'];
    echo "    $month: $cnt entries, Total: $total TZS\n";
}

echo "  Loans by month:\n";
$monthly_loans = finance_db_query($connection, "SELECT TO_CHAR(loan_date, 'YYYY-MM') AS month, COUNT(*) as cnt, SUM(amount) as total FROM loans GROUP BY TO_CHAR(loan_date, 'YYYY-MM') ORDER BY month");
foreach ($monthly_loans ?: [] as $row) {
    $month = $row['month'] ?? $row['MONTH'];
    $cnt = $row['cnt'] ?? $row['CNT'];
    $total = $row['total'] ?? $row['TOTAL'];
    echo "    $month: $cnt entries, Total: $total TZS\n";
}

echo "  Loans by status:\n";
$status_loans = finance_db_query($connection, "SELECT COALESCE(status, 'Unknown') as status, COUNT(*) as cnt FROM loans GROUP BY status");
foreach ($status_loans ?: [] as $row) {
    $status = $row['status'] ?? $row['STATUS'];
    $cnt = $row['cnt'] ?? $row['CNT'];
    echo "    $status: $cnt\n";
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "  ✓ SEEDING COMPLETE\n";
echo "  Dashboard should now display populated charts!\n";
echo "  View at: http://localhost/finance/admin/admin.php\n";
echo "═══════════════════════════════════════════════════════════\n";
?>
