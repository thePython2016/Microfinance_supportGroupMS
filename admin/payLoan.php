<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';
if (isset($_POST['payLoan'])) {
    $id     = uniqid('PM', true);
    $date   = finance_db_escape($connection, $_POST['date']);
    $member = finance_db_escape($connection, $_POST['member']);
    $amount = (float)$_POST['amount'];
    $amountEsc = finance_db_escape($connection, (string)$amount);

    // member column in loanpayments stores the phone number directly
    $result = finance_db_query($connection,
        "INSERT INTO loanPayments (paymentID, date, member, amount)
         VALUES ('$id', '$date', '$member', '$amountEsc')");

    if ($result) {
        finance_db_query($connection,
            "UPDATE loans SET amount = amount - $amountEsc WHERE member = '$member'");
        $_SESSION['flash_success'] = 'Loan payment recorded successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not record payment. ' . ($finance_db_last_error ?? 'Please try again.');
    }
    echo "<script>window.location.href='loan-payment.php';</script>";
}
?>

