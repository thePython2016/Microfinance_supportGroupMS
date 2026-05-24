<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// ── Load .env ──────────────────────────────────────────────────────────────────
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
        $_ENV[trim($key)] = trim($value);
    }
}

// ── Only handle POST ───────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    header("Location: $base/index.php");
    exit;
}

// ── Collect inputs ─────────────────────────────────────────────────────────────
$phone         = trim($_POST['phone']    ?? '');
$plainPassword = trim($_POST['password'] ?? '');

if ($phone === '' || $plainPassword === '') {
    $_SESSION['login_error'] = 'Phone number and password are required.';
    ob_end_clean();
    header("Location: $base/index.php");
    exit;
}

// ── Connect ────────────────────────────────────────────────────────────────────
$host     = getenv('host')     ?: '';
$port     = getenv('port')     ?: '5432';
$database = getenv('database') ?: '';
$dbUser   = getenv('user')     ?: '';
$dbPass   = getenv('password') ?: '';
$sslmode  = getenv('sslmode')  ?: 'require';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$database;sslmode=$sslmode",
        $dbUser, $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    error_log('DB connection failed: ' . $e->getMessage());
    $_SESSION['login_error'] = 'A server error occurred. Please try again later.';
    ob_end_clean();
    header("Location: $base/index.php");
    exit;
}

// ── Fetch account ──────────────────────────────────────────────────────────────
try {
    $stmt = $pdo->prepare(
        'SELECT id, phone, password FROM account WHERE phone = :phone LIMIT 1'
    );
    $stmt->execute([':phone' => $phone]);
    $row = $stmt->fetch();
} catch (PDOException $e) {
    error_log('Login query failed: ' . $e->getMessage());
    $_SESSION['login_error'] = 'A server error occurred. Please try again later.';
    ob_end_clean();
    header("Location: $base/index.php");
    exit;
}

// ── Verify & redirect ──────────────────────────────────────────────────────────
if ($row && password_verify($plainPassword, $row['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['phone']   = $row['phone'];
    ob_end_clean();
    header("Location: $base/admin/admin.php");
    exit;
}

// ── Invalid credentials ────────────────────────────────────────────────────────
$_SESSION['login_error'] = 'Invalid phone number or password.';
ob_end_clean();
header("Location: $base/index.php");
exit;