<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {

    $date   = finance_db_escape($connection, $_POST['date']   ?? '');
    $member = finance_db_escape($connection, $_POST['member'] ?? '');
    $amount = finance_db_escape($connection, (string)($_POST['amount'] ?? ''));

    // Validate required fields before hitting the DB
    if (empty($date) || empty($member) || empty($amount)) {
        $_SESSION['flash_error'] = 'Error: All fields are required.';
        header('Location: shares.php');
        exit;
    }

    // Check member actually exists first
    $memberCheck = finance_db_query($connection,
        "SELECT \"mobileNumber\" FROM members WHERE \"mobileNumber\" = '$member' LIMIT 1");

    if (empty($memberCheck)) {
        $_SESSION['flash_error'] = 'Error: Member with mobile number ' . htmlspecialchars($member) . ' not found.';
        header('Location: shares.php');
        exit;
    }

    $result = finance_db_query($connection,
        "INSERT INTO shares (date, member, amount)
         VALUES ('$date', '$member', '$amount')");

    if ($result) {
        $_SESSION['flash_success'] = 'Share record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add share. ' . ($finance_db_last_error ?? 'Please try again.');
    }

    header('Location: shares.php');
    exit;
}

// Direct access without POST — redirect back
header('Location: shares.php');
exit;
?>