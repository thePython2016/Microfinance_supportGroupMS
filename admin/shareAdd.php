<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {
    $mobile     = finance_db_escape($connection, trim($_POST['member'] ?? ''));
    $share_date = finance_db_escape($connection, trim($_POST['date']   ?? ''));
    $amount     = (float)($_POST['amount'] ?? 0);
    $amountEsc  = finance_db_escape($connection, (string)$amount);

    if (empty($mobile) || empty($share_date) || $amount <= 0) {
        $_SESSION['flash_error'] = 'All fields are required and amount must be greater than zero.';
        header('Location: shares.php');
        exit;
    }

    // 1. Verify that the member actually exists and fetch their proper ID
    $checkMember = finance_db_query($connection, "SELECT id FROM members WHERE mobileNumber='$mobile' LIMIT 1");
    
    // Convert resource/array to a clean array item depending on your custom database wrapper wrapper structure
    $memberRow = !empty($checkMember) ? array_shift($checkMember) : null;

    if (!$memberRow || !isset($memberRow['id'])) {
        $_SESSION['flash_error'] = 'Error: Selected member could not be validated in the system.';
        header('Location: shares.php');
        exit;
    }

    $memberId = (int)$memberRow['id'];

    // 2. Insert into the correct matching column fields: share_date, member_id, amount
    $result = finance_db_query($connection,
        "INSERT INTO shares (share_date, member_id, amount)
         VALUES ('$share_date', '$memberId', '$amountEsc')");

    if ($result) {
        $_SESSION['flash_success'] = 'Share record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add share. ' . ($finance_db_last_error ?? 'Please try again.');
    }
    header('Location: shares.php');
    exit;
}

header('Location: shares.php');
exit;