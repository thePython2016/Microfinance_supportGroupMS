<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {

    $mobile     = finance_db_escape($connection, $_POST['member']  ?? '');
    $share_date = finance_db_escape($connection, $_POST['date']    ?? '');
    $amount     = finance_db_escape($connection, (string)($_POST['amount'] ?? ''));

    if (empty($mobile) || empty($share_date) || empty($amount)) {
        $_SESSION['flash_error'] = 'Error: All fields are required.';
        header('Location: shares.php');
        exit;
    }

    // Look up member's integer id from mobileNumber
    $memberResult = finance_db_query($connection,
        "SELECT id FROM members WHERE \"mobileNumber\" = '$mobile' LIMIT 1");

    if (empty($memberResult)) {
        // Also try lowercase in case driver returns it that way
        $memberResult = finance_db_query($connection,
            "SELECT id FROM members WHERE mobilenumber = '$mobile' LIMIT 1");
    }

    if (empty($memberResult)) {
        $_SESSION['flash_error'] = 'Error: Member not found. Mobile: ' . htmlspecialchars($mobile);
        header('Location: shares.php');
        exit;
    }

    $member_id = (int)($memberResult[0]['id'] ?? 0);

    // Insert only member_id, amount, share_date — id is ALWAYS identity (auto)
    $result = finance_db_query($connection,
        "INSERT INTO shares (member_id, amount, share_date)
         VALUES ($member_id, $amount, '$share_date')");

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
?>