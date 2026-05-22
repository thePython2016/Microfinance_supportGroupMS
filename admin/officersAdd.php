<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';
if (isset($_POST['addOfficers'])) {
    $phone   = finance_db_escape($connection, $_POST['phone']);
    $nin     = finance_db_escape($connection, $_POST['nin']);
    $fname   = finance_db_escape($connection, $_POST['fname']);
    $mname   = finance_db_escape($connection, $_POST['mname']);
    $lname   = finance_db_escape($connection, $_POST['lname']);
    $day     = finance_db_escape($connection, $_POST['day']);
    $month   = finance_db_escape($connection, $_POST['month']);
    $year    = finance_db_escape($connection, $_POST['year']);
    $gender  = finance_db_escape($connection, $_POST['gender']);
    $address = finance_db_escape($connection, $_POST['address']);

    $result = finance_db_query($connection,
        "INSERT INTO officers (mobileNumber,nin,fname,mname,lname,day,month,year,gender,address)
         VALUES ('$phone','$nin','$fname','$mname','$lname','$day','$month','$year','$gender','$address')");

    if ($result) {
        $_SESSION['flash_success'] = 'Financial officer added successfully!';
    } else {
        $_SESSION['flash_error'] = 'Error: Could not add officer. The mobile number or NIN may already exist.';
    }
    echo "<script>window.location.href='financial-officers.php';</script>";
}
?>
