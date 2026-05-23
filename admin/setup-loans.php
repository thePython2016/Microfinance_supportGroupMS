<?php
/**
 * Setup test data for loans
 */

require "connectDB.php";

echo "<h2>Step 1: Adding mobilenumber to loans table...</h2>";

// Add mobilenumber column to loans if missing
try {
    $connection->pdo->query("ALTER TABLE loans ADD COLUMN IF NOT EXISTS mobilenumber VARCHAR(20)");
    echo "✓ mobilenumber column added/verified<br>";
} catch (Exception $e) {
    echo "Note: " . $e->getMessage() . "<br>";
}

echo "<h2>Step 2: Inserting Test Members...</h2>";

$members = [
    ['mobilenumber' => '256701234567', 'fname' => 'John', 'lname' => 'Doe', 'nin' => 'CM123456789'],
    ['mobilenumber' => '256702345678', 'fname' => 'Jane', 'lname' => 'Smith', 'nin' => 'CM987654321'],
    ['mobilenumber' => '256703456789', 'fname' => 'Bob', 'lname' => 'Johnson', 'nin' => 'CM555555555'],
];

foreach ($members as $member) {
    try {
        $stmt = $connection->pdo->prepare("INSERT INTO members (mobilenumber, fname, lname, nin) 
                VALUES (?, ?, ?, ?) ON CONFLICT (mobilenumber) DO NOTHING");
        $stmt->execute([$member['mobilenumber'], $member['fname'], $member['lname'], $member['nin']]);
        echo "✓ Added {$member['fname']} ({$member['mobilenumber']})<br>";
    } catch (Exception $e) {
        echo "❌ {$member['fname']}: " . $e->getMessage() . "<br>";
    }
}

echo "<h2>Step 3: Inserting Test Loans...</h2>";

$loan_data = [
    ['mobilenumber' => '256701234567', 'amount' => 500000, 'interest' => 5],
    ['mobilenumber' => '256702345678', 'amount' => 750000, 'interest' => 6],
    ['mobilenumber' => '256703456789', 'amount' => 1000000, 'interest' => 7],
];

foreach ($loan_data as $loan) {
    try {
        $stmt = $connection->pdo->prepare("INSERT INTO loans (mobilenumber, loan_date, amount, interest_rate, status) 
                VALUES (?, CURRENT_DATE, ?, ?, 'active')");
        $stmt->execute([$loan['mobilenumber'], $loan['amount'], $loan['interest']]);
        echo "✓ Loan: {$loan['amount']} UGX for {$loan['mobilenumber']}<br>";
    } catch (Exception $e) {
        echo "❌ Loan failed: " . $e->getMessage() . "<br>";
    }
}

echo "<h2>Verification:</h2>";
try {
    $members_result = $connection->pdo->query("SELECT COUNT(*) as cnt FROM members");
    $loans_result = $connection->pdo->query("SELECT COUNT(*) as cnt FROM loans");
    
    $m_count = $members_result->fetch(PDO::FETCH_ASSOC)['cnt'];
    $l_count = $loans_result->fetch(PDO::FETCH_ASSOC)['cnt'];
    
    echo "✓ Total Members: $m_count<br>";
    echo "✓ Total Loans: $l_count<br>";
} catch (Exception $e) {
    echo "Error verifying: " . $e->getMessage();
}

echo "<p><strong><a href='check-loan.php'>→ Go to Check Loans</a></strong></p>";
?>

