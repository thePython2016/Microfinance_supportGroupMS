<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

require "connectDB.php";

if (isset($_POST['addMembers'])) {

    // --- Sanitize every POST field (now matches form name="" attributes) ---
    $mobilenumber = finance_db_escape($connection, $_POST['mobilenumber'] ?? '');
    $nin          = finance_db_escape($connection, $_POST['nin']          ?? '');
    $email        = finance_db_escape($connection, $_POST['email']        ?? '');
    $fname        = finance_db_escape($connection, $_POST['fname']        ?? '');
    $mname        = finance_db_escape($connection, $_POST['mname']        ?? '');
    $lname        = finance_db_escape($connection, $_POST['lname']        ?? '');
    $day          = finance_db_escape($connection, $_POST['day']          ?? '');
    $month        = finance_db_escape($connection, $_POST['month']        ?? '');
    $year         = finance_db_escape($connection, $_POST['year']         ?? '');
    $gender       = finance_db_escape($connection, $_POST['gender']       ?? '');
    $address      = finance_db_escape($connection, $_POST['address']      ?? '');
    $status       = finance_db_escape($connection, $_POST['status']       ?? 'active');
    $joined_at    = finance_db_escape($connection, $_POST['joined_at']    ?? date('Y-m-d'));

    // --- Insert into members table ---
    $sql = "INSERT INTO members
                (mobilenumber, nin, email, fname, mname, lname,
                 day, month, year, gender, address, status, joined_at)
            VALUES
                ('$mobilenumber', '$nin', '$email', '$fname', '$mname', '$lname',
                 '$day', '$month', '$year', '$gender', '$address', '$status', '$joined_at')";

    $result = finance_db_query($connection, $sql);

    if ($result) {
        $_SESSION['flash_success'] = "Member added successfully!";
    } else {
        $_SESSION['flash_error'] = "Failed to add member. Please try again.";
    }

    // Redirect back to the form (PRG pattern — prevents duplicate submit on refresh)
    header("Location: members.php");
    exit;

} else {
    // Direct access without form submission
    header("Location: members.php");
    exit;
}
?>