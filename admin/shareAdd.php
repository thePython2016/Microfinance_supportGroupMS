<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {
    $memberId   = (int)($_POST['member_id'] ?? 0);
    $share_date = finance_db_escape($connection, trim($_POST['date']   ?? ''));
    $amount     = (float)($_POST['amount'] ?? 0);
    $amountEsc  = finance_db_escape($connection, (string)$amount);

    if ($memberId <= 0 || empty($share_date) || $amount <= 0) {
        $_SESSION['flash_error'] = 'All fields are required and amount must be greater than zero.';
        header('Location: shares.php');
        exit;
    }

    // Insert directly using the clean member ID from the dropdown value
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