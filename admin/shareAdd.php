<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addShares'])) {
    $mobile     = trim($_POST['member'] ?? '');
    $share_date = finance_db_escape($connection, trim($_POST['date']   ?? ''));
    $amount     = (float)($_POST['amount'] ?? 0);
    $amountEsc  = finance_db_escape($connection, (string)$amount);

    if (empty($mobile) || empty($share_date) || $amount <= 0) {
        $_SESSION['flash_error'] = 'All fields are required and amount must be greater than zero.';
        header('Location: shares.php');
        exit;
    }

    // Strip out spaces or extra characters to match clean storage standard
    $cleanMobile = finance_db_escape($connection, str_replace(["'", '"', " "], "", $mobile));

    // 1. Validates string values against implicit column types (Text/BigInt variants) safely
    $checkMember = finance_db_query($connection, 
        "SELECT id FROM members WHERE 
         TRIM(CAST(\"mobileNumber\" AS TEXT)) = '$cleanMobile' 
         OR TRIM(CAST(mobilenumber AS TEXT)) = '$cleanMobile' 
         OR \"mobileNumber\" = '$cleanMobile' 
         OR mobilenumber = '$cleanMobile' 
         LIMIT 1"
    );
    
    $memberRow = !empty($checkMember) ? array_shift($checkMember) : null;

    if (!$memberRow) {
        $_SESSION['flash_error'] = "Error: Member validation failed. (Number checked: " . htmlspecialchars($mobile) . ")";
        header('Location: shares.php');
        exit;
    }

    $memberId = null;
    if (isset($memberRow['id'])) $memberId = (int)$memberRow['id'];
    if (isset($memberRow['ID'])) $memberId = (int)$memberRow['ID'];
    
    if (!$memberId) {
        $_SESSION['flash_error'] = 'Error: Valid member index found, but mapping layout profile keys failed.';
        header('Location: shares.php');
        exit;
    }

    // 2. Maps clean IDs cleanly into transaction records
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