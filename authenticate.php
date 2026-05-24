<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Dynamic base path ──────────────────────────────────────────────────────────
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// ── Load .env ──────────────────────────────────────────────────────────────────
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);
        putenv("$key=$value");
        $_ENV[$key] = $value;
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

// Normalize phone to digits only and enforce exactly 10 digits
$phone_digits = preg_replace('/\D/', '', $phone);
if ($phone_digits === '' || $plainPassword === '') {
    $_SESSION['login_error'] = 'Phone number and password are required.';
    ob_end_clean();
    header("Location: $base/index.php");
    exit;
}
if (strlen($phone_digits) !== 10) {
    $_SESSION['login_error'] = 'Phone number must be exactly 10 digits.';
    ob_end_clean();
    header("Location: $base/index.php");
    exit;
}
// use normalized phone for lookup
$phone = $phone_digits;

// ── Connect ────────────────────────────────────────────────────────────────────
$host     = getenv('host')     ?: '';
$port     = getenv('port')     ?: '5432';
$database = getenv('database') ?: '';
$dbUser   = getenv('user')     ?: '';
$dbPass   = getenv('password') ?: '';
$sslmode  = getenv('sslmode')  ?: 'require';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=$sslmode";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
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
    $_SESSION['user_id']  = $row['id'];
    $_SESSION['phone']    = $row['phone'];
    $_SESSION['username'] = $row['phone']; // alias so admin.php works with either
    ob_end_clean();
    header("Location: $base/admin/admin.php");
    exit;
}

// ── Invalid credentials ────────────────────────────────────────────────────────
$_SESSION['login_error'] = 'Invalid phone number or password.';
ob_end_clean();
header("Location: $base/index.php");
exit;