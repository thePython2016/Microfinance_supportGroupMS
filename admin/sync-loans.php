<?php
/**
 * Sync mobile numbers from members to loans
 * This will update loans with mobilenumbers that actually exist in members
 */

require "connectDB.php";

echo "<h2>Data Synchronization</h2>";

// Get all existing members
$members = finance_db_query($connection, "SELECT id, mobilenumber FROM members ORDER BY id LIMIT 10");

if (!$members || $members->num_rows == 0) {
    echo "<p style='color:red;'><strong>ERROR: No members found. Run setup-loans.php first.</strong></p>";
    echo "<p><a href='setup-loans.php'>Go to setup-loans.php</a></p>";
    die();
}

$member_list = [];
foreach ($members as $m) {
    $member_list[] = $m['mobilenumber'];
}

echo "<h3>Members Found:</h3>";
foreach ($member_list as $num) {
    echo "✓ " . htmlspecialchars($num) . "<br>";
}

echo "<h3>Updating Loans Table...</h3>";

// Clear existing loans
try {
    $connection->pdo->query("DELETE FROM loans");
    echo "✓ Cleared old loans<br>";
} catch (Exception $e) {
    echo "Note: " . $e->getMessage() . "<br>";
}

// Insert new loans with matching mobilenumbers
$i = 0;
foreach ($member_list as $mobile) {
    $amounts = [500000, 750000, 1000000, 1200000];
    $amount = $amounts[$i % count($amounts)];
    
    try {
        $stmt = $connection->pdo->prepare(
            "INSERT INTO loans (mobilenumber, loan_date, amount, interest_rate, status) 
             VALUES (?, CURRENT_DATE, ?, ?, 'active')"
        );
        $stmt->execute([$mobile, $amount, 5]);
        echo "✓ Added loan for $mobile ($amount UGX)<br>";
        $i++;
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "<br>";
    }
}

echo "<h3>Verification:</h3>";
try {
    $loans_result = $connection->pdo->query("SELECT COUNT(*) as cnt FROM loans");
    $loan_count = $loans_result->fetch(PDO::FETCH_ASSOC)['cnt'];
    echo "✓ Total Loans: $loan_count<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "<p style='margin-top:20px;'>";
echo "<strong><a href='check-loan.php' class='btn btn-primary'>Go to Check Loans</a></strong>";
echo "</p>";
?>
