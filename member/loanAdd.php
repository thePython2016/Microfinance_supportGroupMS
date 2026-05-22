<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';
if (isset($_POST['addLoan'])) {
    $date   = finance_db_escape($connection, $_POST['date']);
    $member = finance_db_escape($connection, $_POST['member']);
    $amount = (float)$_POST['amount'];
    $interest    = ($amount < 100000) ? $amount * 0.2 : $amount * 0.15;
    $amountEsc   = finance_db_escape($connection, (string)$amount);
    $interestEsc = finance_db_escape($connection, (string)$interest);

    $result = finance_db_query($connection,
        "INSERT INTO loans (date, member, amount, interest)
         VALUES ('$date', (SELECT mobileNumber FROM members WHERE mobileNumber='$member'), '$amountEsc', '$interestEsc')");

    if ($result) {
        $_SESSION['flash_success'] = 'Loan record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add loan. ' . ($finance_db_last_error ?? 'Please try again.');
    }
    echo "<script>window.location.href='loans.php';</script>";
}
?>
