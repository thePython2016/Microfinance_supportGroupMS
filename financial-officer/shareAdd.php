<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';
if (isset($_POST['addShares'])) {
    $date   = finance_db_escape($connection, $_POST['date']);
    $member = finance_db_escape($connection, $_POST['member']);
    $amount = finance_db_escape($connection, (string)$_POST['amount']);

    $result = finance_db_query($connection,
        "INSERT INTO shares (date, member, amount)
         VALUES ('$date', (SELECT mobileNumber FROM members WHERE mobileNumber='$member'), '$amount')");

    if ($result) {
        $_SESSION['flash_success'] = 'Share record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add share. ' . ($finance_db_last_error ?? 'Please try again.');
    }
    echo "<script>window.location.href='shares.php';</script>";
}
?>
