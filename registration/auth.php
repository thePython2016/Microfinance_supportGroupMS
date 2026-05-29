<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Only handle POST ───────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: register.php');
    exit;
}

// ── Collect inputs ─────────────────────────────────────────────────────────────
$phone           = trim($_POST['phone']           ?? '');
$address         = trim($_POST['address']         ?? '');
$password        = $_POST['password']             ?? '';
$confirmPassword = $_POST['confirm_password']     ?? '';

// ── Helper: redirect back with error ──────────────────────────────────────────
function redirectWithError(string $message, string $phone, string $address): never {
    $_SESSION['login_error'] = $message;
    $_SESSION['old_phone']   = $phone;
    $_SESSION['old_address'] = $address;
    header('Location: register.php');
    exit;
}

// ── Validate ───────────────────────────────────────────────────────────────────
if (empty($phone))
    redirectWithError('Phone number is required.', $phone, $address);

// Normalize phone to digits only and require exactly 10 digits
$digits = preg_replace('/\D/', '', $phone);
if (strlen($digits) !== 10) {
    redirectWithError('Phone number must be exactly 10 digits.', $phone, $address);
}
$phone = $digits;

if (empty($address))
    redirectWithError('Address is required.', $phone, $address);

if (empty($password))
    redirectWithError('Password is required.', $phone, $address);

if (strlen($password) < 6)
    redirectWithError('Password must be at least 6 characters.', $phone, $address);

if ($password !== $confirmPassword)
    redirectWithError('Passwords do not match.', $phone, $address);

// ── Connect using the shared database helper (handles Render DATABASE_URL and local .env) ──
require_once dirname(__DIR__) . '/includes/mysqli_pgsql.php';

try {
    $connection = finance_db_connect();
    $pdo = $connection->pdo;
} catch (Exception $e) {
    error_log('DB connection failed: ' . $e->getMessage());
    redirectWithError('Database connection failed. Please try again later.', $phone, $address);
}

// ── Check duplicate phone ──────────────────────────────────────────────────────
try {
    $stmt = $pdo->prepare('SELECT id FROM account WHERE phone = :phone');
    $stmt->execute([':phone' => $phone]);
    if ($stmt->fetch()) {
        redirectWithError('That phone number is already registered.', $phone, $address);
    }
} catch (PDOException $e) {
    error_log('Duplicate check failed: ' . $e->getMessage());
    redirectWithError('A server error occurred. Please try again.', $phone, $address);
}

// ── Hash & insert ──────────────────────────────────────────────────────────────
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    $insert = $pdo->prepare('
        INSERT INTO account (phone, address, password)
        VALUES (:phone, :address, :password)
    ');
    $insert->execute([
        ':phone'    => $phone,
        ':address'  => $address,
        ':password' => $hashedPassword,
    ]);
    $newUserId = $pdo->lastInsertId();
} catch (PDOException $e) {
    error_log('Insert failed: ' . $e->getMessage());
    redirectWithError('Could not create your account. Please try again.', $phone, $address);
}

// ── Success: redirect to index.php one level up ────────────────────────────────
session_regenerate_id(true);
$_SESSION['user_id'] = $newUserId;
$_SESSION['phone']   = $phone;

unset($_SESSION['old_phone'], $_SESSION['old_address']);
$_SESSION['success'] = 'Account created successfully! Please log in.';

// Works regardless of subfolder name
$indexUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$indexUrl = dirname($indexUrl) . '/index.php';
header('Location: ' . $indexUrl);
exit;