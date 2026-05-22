<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addMembers'])) {
    $mobilenumber = finance_db_escape($connection, $_POST['mobilenumber'] ?? '');
    $nin          = finance_db_escape($connection, $_POST['nin']          ?? '');
    $email        = finance_db_escape($connection, $_POST['email']        ?? '');
    $fname        = finance_db_escape($connection, $_POST['fname']        ?? '');
    $mname        = finance_db_escape($connection, $_POST['mname']        ?? '');
    $lname        = finance_db_escape($connection, $_POST['lname']        ?? '');
    $day          = finance_db_escape($connection, $_POST['day']          ?? '1');
    $month        = finance_db_escape($connection, $_POST['month']        ?? '1');
    $year         = finance_db_escape($connection, $_POST['year']         ?? date('Y'));
    $gender       = finance_db_escape($connection, $_POST['gender']       ?? '');
    $address      = finance_db_escape($connection, $_POST['address']      ?? '');
    $status       = finance_db_escape($connection, $_POST['status']       ?? 'active');
    $joined_at    = finance_db_escape($connection, $_POST['joined_at']    ?? date('Y-m-d'));

    $result = finance_db_query($connection,
        "INSERT INTO members (mobilenumber, nin, email, fname, mname, lname, day, month, year, gender, address, status, joined_at)
         VALUES ('$mobilenumber', '$nin', '$email', '$fname', '$mname', '$lname',
                 $day::int, $month::int,
                 make_timestamp($year::int, $month::int, $day::int, 0, 0, 0),
                 '$gender', '$address', '$status', '$joined_at'::timestamp)");

    if ($result) {
        $_SESSION['flash_success'] = 'Member added successfully!';
    } else {
        global $finance_db_last_error;
        $_SESSION['flash_error'] = 'Error: Could not add member. The mobile number or NIN may already exist.' . ($finance_db_last_error ?? '');
    }
    header('Location: members.php');
    exit;
}
?>