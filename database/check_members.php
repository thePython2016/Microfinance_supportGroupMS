<?php
/**
 * Quick diagnostic — visit /database/check_members.php to see what's in the DB.
 */
require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';
require_once dirname(__DIR__) . '/includes/sql_compat.php';

$connection = finance_db_connect();
?>
<!DOCTYPE html><html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4" style="max-width:900px">
<h4>DB Diagnostic</h4>
<hr>

<?php
// 1. Raw base-table count
try {
    $r = $connection->pdo->query("SELECT COUNT(*) AS n FROM members");
    $cnt = $r->fetchColumn();
    echo "<div class='alert alert-info'>Base <b>members</b> table row count: <b>$cnt</b></div>";
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>members table error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// 2. app_members view check
try {
    $r = $connection->pdo->query("SELECT COUNT(*) AS n FROM app_members");
    $cnt = $r->fetchColumn();
    echo "<div class='alert alert-info'><b>app_members</b> view row count: <b>$cnt</b></div>";
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>app_members view error: " . htmlspecialchars($e->getMessage()) . " — run <a href='setup.php'>setup.php</a></div>";
}

// 3. Show what sql_compat produces for the dropdown query
$raw = "SELECT mobileNumber, fname, lname FROM members ORDER BY fname";
$transformed = finance_compat_sql($raw);
echo "<div class='alert alert-secondary'><b>Dropdown query after compat:</b><br><code>" . htmlspecialchars($transformed) . "</code></div>";

// 4. Run the actual dropdown query
$result = finance_db_query($connection, $raw);
if ($result === false) {
    global $finance_db_last_error;
    echo "<div class='alert alert-danger'>Dropdown query FAILED: " . htmlspecialchars($finance_db_last_error ?? 'unknown') . "</div>";
} else {
    $rows = [];
    foreach ($result ?: [] as $row) { $rows[] = $row; }
    echo "<div class='alert alert-success'>Dropdown query returned <b>" . count($rows) . "</b> row(s).</div>";
    if ($rows) {
        echo "<table class='table table-sm table-bordered'><tr><th>mobileNumber</th><th>fname</th><th>lname</th></tr>";
        foreach ($rows as $row) {
            echo "<tr><td>" . htmlspecialchars($row['mobileNumber'] ?? $row['mobilenumber'] ?? '—') . "</td>"
               . "<td>" . htmlspecialchars($row['fname'] ?? '—') . "</td>"
               . "<td>" . htmlspecialchars($row['lname'] ?? '—') . "</td></tr>";
        }
        echo "</table>";
    }
}

// 5. Direct PDO query (bypasses compat)
echo "<hr><h6>Direct PDO query (bypasses compat):</h6>";
try {
    $stmt = $connection->pdo->query("SELECT mobilenumber, fname, lname FROM members ORDER BY fname LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<div class='alert alert-success'>Direct query returned <b>" . count($rows) . "</b> row(s).</div>";
    if ($rows) {
        echo "<pre>" . htmlspecialchars(print_r($rows, true)) . "</pre>";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Direct query error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
<a href="setup.php" class="btn btn-primary">Run setup.php</a>
</body></html>
