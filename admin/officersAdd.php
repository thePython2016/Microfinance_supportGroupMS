<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';

if (isset($_POST['addOfficers'])) {
    global $finance_db_last_error;

    $phone      = finance_db_escape($connection, $_POST['phone']      ?? '');
    $nin        = finance_db_escape($connection, $_POST['nin']        ?? '');
    $fname      = finance_db_escape($connection, $_POST['fname']      ?? '');
    $mname      = finance_db_escape($connection, $_POST['mname']      ?? '');
    $lname      = finance_db_escape($connection, $_POST['lname']      ?? '');
    $day        = finance_db_escape($connection, $_POST['day']        ?? '');
    $month      = finance_db_escape($connection, $_POST['month']      ?? '');
    $year       = finance_db_escape($connection, $_POST['year']       ?? '');
    $gender     = finance_db_escape($connection, $_POST['gender']     ?? '');
    $address    = finance_db_escape($connection, $_POST['address']    ?? '');
    $occupation = finance_db_escape($connection, $_POST['occupation'] ?? '');

    $sql = "INSERT INTO officers (mobileNumber, nin, fname, mname, lname, day, month, year, gender, address, occupation)
            VALUES ('$phone','$nin','$fname','$mname','$lname','$day','$month','$year','$gender','$address','$occupation')";

    $result = finance_db_query($connection, $sql);

    if ($result) {
        $_SESSION['flash_success'] = "Financial officer $fname $lname added successfully!";
    } else {
        $_SESSION['flash_error'] = 'Error: ' . ($finance_db_last_error ?? 'Unknown error');
    }
}

header('Location: financial-officers.php');
exit;