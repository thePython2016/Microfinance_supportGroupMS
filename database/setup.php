<?php
/**
 * One-time database setup page.
 * Visit this URL once to create/recreate all tables and compatibility views.
 * Access: https://your-app.onrender.com/database/setup.php
 */

require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

$results = [];
$hasError = false;

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

$connection = finance_db_connect();

apply_sql_file('postgres_schema.sql',   __DIR__ . '/postgres_schema.sql',   $connection, $results, $hasError);
apply_sql_file('supabase_compat.sql',   __DIR__ . '/supabase_compat.sql',   $connection, $results, $hasError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Database Setup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h3>Database Setup</h3>
  <p class="text-muted">This page creates all tables and compatibility views. Safe to re-run — uses <code>CREATE IF NOT EXISTS</code> and <code>CREATE OR REPLACE VIEW</code>.</p>
  <hr>
  <?php foreach ($results as $r): ?>
    <div class="alert alert-<?php echo $r['status'] === 'ok' ? 'success' : 'danger'; ?>">
      <strong><?php echo htmlspecialchars($r['label']); ?>:</strong>
      <?php echo htmlspecialchars($r['msg']); ?>
    </div>
  <?php endforeach; ?>
  <?php if (!$hasError): ?>
    <div class="alert alert-success fw-bold">✅ Setup complete! All tables and views are ready.</div>
    <a href="../admin/admin.php" class="btn btn-primary">Go to Admin Dashboard</a>
  <?php else: ?>
    <div class="alert alert-warning">⚠️ Some steps failed. Check the errors above and ensure your DATABASE_URL environment variable is set correctly on Render.</div>
  <?php endif; ?>
</body>
</html>
