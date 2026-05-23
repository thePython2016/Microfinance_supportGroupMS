<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (!isset($_POST['addShares'])) {
    header('Location: shares.php');
    exit;
}

$mobile     = trim($_POST['member'] ?? '');
$share_date = trim($_POST['date']   ?? '');
$amount     = (float)($_POST['amount'] ?? 0);

if (empty($mobile) || empty($share_date) || $amount <= 0) {
    $_SESSION['flash_error'] = 'All fields are required and amount must be greater than zero.';
    header('Location: shares.php');
    exit;
}

try {
    // 1. Look up member's integer id directly (bypass compat layer)
    $stmt = $connection->pdo->prepare(
        "SELECT id FROM members WHERE mobilenumber = ? LIMIT 1"
    );
    $stmt->execute([$mobile]);
    $memberRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$memberRow) {
        $_SESSION['flash_error'] = 'Member not found for mobile number: ' . htmlspecialchars($mobile);
        header('Location: shares.php');
        exit;
    }

    $member_id = (int)$memberRow['id'];

    // 2. Insert the share directly (bypass compat layer)
    $stmt = $connection->pdo->prepare(
        "INSERT INTO shares (share_date, member_id, amount) VALUES (?, ?, ?)"
    );
    $stmt->execute([$share_date, $member_id, $amount]);

    $_SESSION['flash_success'] = 'Share record added successfully!';

} catch (PDOException $e) {
    $_SESSION['flash_error'] = 'Error: Could not add share. ' . $e->getMessage();
}

header('Location: shares.php');
exit;
