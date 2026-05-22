<?php
session_start();
require "admin/connectDB.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $username = finance_db_escape($connection, $username);
    $pass = finance_db_escape($connection, $pass);

    $selectuser = "select username,password,user_category from profile where username='$username' AND password='$pass'";
    $user = finance_db_query($connection, $selectuser);
    $usercat = finance_db_fetch_array($user);

    if (is_array($usercat) && isset($usercat['user_category'])) {
        $returncat = (int) $usercat['user_category'];
        $_SESSION['username'] = $username;

        if ($returncat === 1) {
            header("Location:admin/admin.php");
            exit;
        }
        if ($returncat === 2) {
            header("Location:member/macro-member.php");
            exit;
        }
        if ($returncat === 3) {
            header("Location:financial-officer/financial-officer.php");
            exit;
        }
    }

    $_SESSION['login_error'] = 'Invalid username or password.';
    header("Location:index.php");
    exit;
}
