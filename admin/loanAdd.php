<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addLoan'])) {

    $loan_date    = finance_db_escape($connection, $_POST['loan_date']    ?? '');
    $due_date     = finance_db_escape($connection, $_POST['due_date']     ?? '');
    $member_id    = finance_db_escape($connection, $_POST['member_id']    ?? '');
    $status       = finance_db_escape($connection, $_POST['status']       ?? 'active');
    $notes        = finance_db_escape($connection, $_POST['notes']        ?? '');

    $amount        = (float)($_POST['amount']        ?? 0);
    $interest_rate = (float)($_POST['interest_rate'] ?? 0);
    $total_payable = (float)($_POST['total_payable'] ?? ($amount * (1 + $interest_rate / 100)));

    // derive month and year from loan_date
    $month = date('n', strtotime($loan_date));
    $year  = date('Y', strtotime($loan_date));

    $amountEsc        = finance_db_escape($connection, (string)$amount);
    $interestRateEsc  = finance_db_escape($connection, (string)$interest_rate);
    $totalPayableEsc  = finance_db_escape($connection, (string)$total_payable);
    $monthEsc         = finance_db_escape($connection, (string)$month);
    $yearEsc          = finance_db_escape($connection, (string)$year);

    $result = finance_db_query($connection,
        "INSERT INTO loans
            (member_id, amount, interest_rate, total_payable, loan_date, due_date, month, year, status, notes)
         VALUES
            ('$member_id', '$amountEsc', '$interestRateEsc', '$totalPayableEsc',
             '$loan_date', '$due_date', '$monthEsc', '$yearEsc', '$status', '$notes')"
    );

    if ($result) {
        $_SESSION['flash_success'] = 'Loan record added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add loan. ' . ($finance_db_last_error ?? 'Please try again.');
    }

    echo "<script>window.location.href='loans.php';</script>";
}
?>