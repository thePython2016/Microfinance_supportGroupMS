<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {

    $phone      = finance_db_escape($connection, $_POST['member'] ?? '');
    $share_date = finance_db_escape($connection, $_POST['date']   ?? '');
    $amount     = finance_db_escape($connection, (string)($_POST['amount'] ?? ''));

    // Validate required fields
    if (empty($phone) || empty($share_date) || empty($amount)) {
        $_SESSION['flash_error'] = 'Error: All fields are required.';
        header('Location: shares.php?phone=' . urlencode($phone));
        exit;
    }

    // Look up the member's integer id using their mobileNumber
    $memberResult = finance_db_query($connection,
        "SELECT id FROM members WHERE \"mobileNumber\" = '$phone' LIMIT 1");

    if (empty($memberResult)) {
        $_SESSION['flash_error'] = 'Error: Member with mobile number ' . htmlspecialchars($phone) . ' not found.';
        header('Location: shares.php?phone=' . urlencode($phone));
        exit;
    }

    $member_id = (int)$memberResult[0]['id'];

    // Insert using correct column names: member_id (int), amount (numeric), share_date (date)
    $result = finance_db_query($connection,
        "INSERT INTO shares (member_id, amount, share_date)
         VALUES ($member_id, $amount, '$share_date')");

    if ($result) {
        $_SESSION['flash_success'] = 'Share record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add share. ' . ($finance_db_last_error ?? 'Please try again.');
    }

    header('Location: shares.php?phone=' . urlencode($phone));
    exit;
}

// Direct access without POST — redirect back
header('Location: shares.php');
exit;
?>