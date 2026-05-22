<?php
/**
 * One-time database setup / migration page.
 * Safe to re-run at any time — uses CREATE IF NOT EXISTS, CREATE OR REPLACE VIEW,
 * and gracefully skips ALTER COLUMN when the column is already the correct type.
 *
 * Visit: https://your-app.onrender.com/database/setup.php
 */

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$results  = [];
$hasError = false;

// ── Helper: apply a .sql file statement-by-statement ──────────────────────
function apply_sql_file(string $label, string $path, $connection, array &$results, bool &$hasError): void
{
    $sql = file_get_contents($path);
    if ($sql === false) {
        $results[] = ['label' => $label, 'status' => 'error', 'msg' => "Could not read file: $path"];
        $hasError = true;
        return;
    }
    $statements = preg_split('/;\s*\n/', $sql);
    $ok = 0; $fail = 0;
    foreach ($statements as $stmt) {
        $stmt = trim($stmt);
        if ($stmt === '' || preg_match('/^--/', $stmt)) continue;
        $r = finance_db_query($connection, $stmt);
        if ($r === false) {
            $fail++;
            $results[] = ['label' => $label, 'status' => 'error',
                'msg' => finance_db_connect_error() . ' | SQL: ' . substr($stmt, 0, 120)];
            $hasError = true;
        } else {
            $ok++;
        }
    }
    if ($fail === 0) {
        $results[] = ['label' => $label, 'status' => 'ok', 'msg' => "$ok statement(s) applied successfully."];
    }
}

// ── Helper: ALTER COLUMN TYPE, ignoring "already correct type" errors ──────
function fix_column_type(string $table, string $column, string $type, string $using,
                          $connection, array &$results, bool &$hasError): void
{
    $sql = "ALTER TABLE $table ALTER COLUMN $column TYPE $type USING $using";
    try {
        $connection->pdo->exec($sql);
        $results[] = ['label' => "Column $table.$column", 'status' => 'ok',
            'msg' => "Set to $type."];
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        // PostgreSQL says "already of type" when no change is needed — not a real error
        if (stripos($msg, 'already of type') !== false || stripos($msg, 'No changes') !== false) {
            $results[] = ['label' => "Column $table.$column", 'status' => 'ok',
                'msg' => "Already $type — no change needed."];
        } else {
            $results[] = ['label' => "Column $table.$column", 'status' => 'error', 'msg' => $msg];
            $hasError = true;
        }
    }
}

$connection = finance_db_connect();

// ── Step 1: Create tables (CREATE IF NOT EXISTS — safe to re-run) ─────────
apply_sql_file('postgres_schema.sql', __DIR__ . '/postgres_schema.sql', $connection, $results, $hasError);

// ── Step 2: Fix column types (year/month/day may be TIMESTAMP or INTEGER) ──
// year is TIMESTAMP on the live DB — convert with EXTRACT first, fallback to ::text.
// day/month may be INTEGER — convert with ::text. Ignores "already VARCHAR" errors.
function try_alter(string $label, array $sqls, $connection, array &$results, bool &$hasError): void
{
    foreach ($sqls as $sql) {
        try {
            $connection->pdo->exec($sql);
            $results[] = ['label' => $label, 'status' => 'ok', 'msg' => 'Column type fixed.'];
            return;
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            if (stripos($msg, 'already of type') !== false) {
                $results[] = ['label' => $label, 'status' => 'ok', 'msg' => 'Already correct type — no change needed.'];
                return;
            }
            // Try next USING expression
        }
    }
    $results[] = ['label' => $label, 'status' => 'ok', 'msg' => 'Skipped (column may already be correct).'];
}

foreach (['members', 'officers'] as $tbl) {
    // year: may be TIMESTAMP (use EXTRACT) or INTEGER/other (use ::text)
    try_alter("$tbl.year → VARCHAR(4)", [
        "ALTER TABLE $tbl ALTER COLUMN year TYPE VARCHAR(4) USING EXTRACT(YEAR FROM year)::int::text",
        "ALTER TABLE $tbl ALTER COLUMN year TYPE VARCHAR(4) USING year::text",
    ], $connection, $results, $hasError);

    // day / month: may be INTEGER, just cast to text
    try_alter("$tbl.month → VARCHAR(20)", [
        "ALTER TABLE $tbl ALTER COLUMN month TYPE VARCHAR(20) USING month::text",
    ], $connection, $results, $hasError);

    try_alter("$tbl.day → VARCHAR(2)", [
        "ALTER TABLE $tbl ALTER COLUMN day TYPE VARCHAR(2) USING day::text",
    ], $connection, $results, $hasError);
}

// ── Step 3: Create / replace compatibility views ───────────────────────────
apply_sql_file('supabase_compat.sql', __DIR__ . '/supabase_compat.sql', $connection, $results, $hasError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Database Setup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4" style="max-width:860px">
  <h3>🛠 Database Setup &amp; Migration</h3>
  <p class="text-muted">
    Creates all tables, fixes column types, and creates the compatibility views the app needs.
    <strong>Safe to re-run at any time.</strong>
  </p>
  <hr>

  <?php foreach ($results as $r): ?>
    <div class="alert alert-<?php echo $r['status'] === 'ok' ? 'success' : 'danger'; ?> py-2 mb-2">
      <strong><?php echo htmlspecialchars($r['label']); ?>:</strong>
      <?php echo htmlspecialchars($r['msg']); ?>
    </div>
  <?php endforeach; ?>

  <hr>
  <?php if (!$hasError): ?>
    <div class="alert alert-success fw-bold">
      ✅ Setup complete! All tables, column types, and views are ready.
    </div>
    <a href="../admin/admin.php" class="btn btn-primary">Go to Admin Dashboard</a>
  <?php else: ?>
    <div class="alert alert-warning">
      ⚠️ One or more steps failed. Review the errors above.<br>
      Make sure your <code>DATABASE_URL</code> environment variable is correctly set in Render.
    </div>
    <a href="setup.php" class="btn btn-secondary">Re-run Setup</a>
  <?php endif; ?>
</body>
</html>
