<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {

    $member_id  = (int)($_POST['member_id'] ?? 0);
    $share_date = finance_db_escape($connection, $_POST['date']   ?? '');
    $amount     = finance_db_escape($connection, (string)($_POST['amount'] ?? ''));

    if (empty($member_id) || empty($share_date) || empty($amount)) {
        $_SESSION['flash_error'] = 'Error: All fields are required.';
        header('Location: shares.php?phone=' . urlencode($_POST['phone'] ?? ''));
        exit;
    }

    // id is auto-increment — only insert member_id, amount, share_date
    $result = finance_db_query($connection,
        "INSERT INTO shares (member_id, amount, share_date)
         VALUES ($member_id, $amount, '$share_date')");

    if ($result) {
        $_SESSION['flash_success'] = 'Share record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add share. ' . ($finance_db_last_error ?? 'Please try again.');
    }

    header('Location: shares.php?phone=' . urlencode($_POST['phone'] ?? ''));
    exit;
}

header('Location: shares.php');
exit;
?>