<?php
/**
 * Verify data consistency between members and loans tables
 */

require "connectDB.php";

echo "<h2>Data Verification</h2>";

echo "<h3>Members in Database:</h3>";
$members = finance_db_query($connection, "SELECT id, mobilenumber, fname FROM members");
if ($members && $members->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Mobile Number</th><th>Name</th></tr>";
    foreach ($members as $m) {
        echo "<tr><td>{$m['id']}</td><td>{$m['mobilenumber']}</td><td>{$m['fname']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red;'>No members found</p>";
}

echo "<h3>Loans in Database:</h3>";
$loans = finance_db_query($connection, "SELECT id, mobilenumber, amount FROM loans");
if ($loans && $loans->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Mobile Number</th><th>Amount</th></tr>";
    foreach ($loans as $l) {
        echo "<tr><td>{$l['id']}</td><td>{$l['mobilenumber']}</td><td>{$l['amount']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red;'>No loans found</p>";
}

echo "<h3>Matching Analysis:</h3>";
$loans = finance_db_query($connection, "SELECT DISTINCT mobilenumber FROM loans");
$matched = 0;
$unmatched = [];

foreach ($loans as $loan) {
    $check = finance_db_query($connection, "SELECT COUNT(*) as cnt FROM members WHERE mobilenumber='{$loan['mobilenumber']}'");
    foreach ($check as $c) {
        if ($c['cnt'] > 0) {
            $matched++;
        } else {
            $unmatched[] = $loan['mobilenumber'];
        }
    }
}

echo "<p><strong>Matched:</strong> $matched loans have corresponding members</p>";
if (count($unmatched) > 0) {
    echo "<p style='color:red;'><strong>Unmatched Mobile Numbers (in loans but not in members):</strong></p>";
    foreach ($unmatched as $num) {
        echo "- $num<br>";
    }
}
?>
