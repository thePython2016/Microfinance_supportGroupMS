<?php
/**
 * Insert test data for members and loans
 * Run once: http://localhost/finance/admin/seed-test-data.php
 */

require "connectDB.php";

// Insert test members
$members = [
    ['mobilenumber' => '256701234567', 'fname' => 'John', 'lname' => 'Doe', 'nin' => 'CM123456789'],
    ['mobilenumber' => '256702345678', 'fname' => 'Jane', 'lname' => 'Smith', 'nin' => 'CM987654321'],
    ['mobilenumber' => '256703456789', 'fname' => 'Bob', 'lname' => 'Johnson', 'nin' => 'CM555555555'],
];

echo "<h2>Inserting Test Members...</h2>";
foreach ($members as $member) {
    $sql = "INSERT INTO members (mobilenumber, fname, lname, nin) 
            VALUES ('{$member['mobilenumber']}', '{$member['fname']}', '{$member['lname']}', '{$member['nin']}')
            ON CONFLICT (mobilenumber) DO NOTHING";
    $result = finance_db_query($connection, $sql);
    if ($result === false) {
        echo "❌ Failed to insert {$member['fname']}: " . $GLOBALS['finance_db_last_error'] . "<br>";
    } else {
        echo "✓ Added {$member['fname']} ({$member['mobilenumber']})<br>";
    }
}

// Get member IDs for loans
$members_query = finance_db_query($connection, "SELECT id, mobilenumber FROM members ORDER BY id DESC LIMIT 3");
$member_ids = [];
if ($members_query && $members_query->num_rows > 0) {
    foreach ($members_query as $row) {
        $member_ids[] = $row['id'];
    }
}

// Insert test loans
echo "<h2>Inserting Test Loans...</h2>";
if (count($member_ids) >= 2) {
    $loans = [
        ['member_id' => $member_ids[0], 'amount' => 500000, 'interest' => 5],
        ['member_id' => $member_ids[1], 'amount' => 750000, 'interest' => 6],
        ['member_id' => $member_ids[2], 'amount' => 1000000, 'interest' => 7],
    ];

    foreach ($loans as $loan) {
        $sql = "INSERT INTO loans (member_id, loan_date, amount, interest_rate) 
                VALUES ({$loan['member_id']}, CURRENT_DATE, {$loan['amount']}, {$loan['interest']})";
        $result = finance_db_query($connection, $sql);
        if ($result === false) {
            echo "❌ Failed to insert loan: " . $GLOBALS['finance_db_last_error'] . "<br>";
        } else {
            echo "✓ Added loan: {$loan['amount']} UGX (Member ID: {$loan['member_id']})<br>";
        }
    }
} else {
    echo "❌ Not enough members to create loans<br>";
}

// Verify data
echo "<h2>Verification:</h2>";
$m_count = finance_db_query($connection, "SELECT COUNT(*) as cnt FROM members");
$l_count = finance_db_query($connection, "SELECT COUNT(*) as cnt FROM loans");

foreach ($m_count as $row) {
    echo "✓ Members: " . $row['cnt'] . "<br>";
}
foreach ($l_count as $row) {
    echo "✓ Loans: " . $row['cnt'] . "<br>";
}

echo "<p><a href='check-loan.php'>✓ Go to Check Loans</a></p>";
?>
