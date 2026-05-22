<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "admin/connectDB.php";
require_once dirname(__FILE__) . "/includes/auth.php";

if (isset($_POST['submit'])) {
    $username = trim((string) ($_POST['username'] ?? ''));
    $plainPassword = (string) ($_POST['password'] ?? '');

    if ($username === '' || $plainPassword === '') {
        $_SESSION['login_error'] = 'Invalid username or password.';
        header("Location:index.php");
        exit;
    }

    $username = finance_db_escape($connection, $username);

    $selectuser = "SELECT username, password, user_category FROM profile WHERE username='$username' LIMIT 1";
    $user = finance_db_query($connection, $selectuser);
    $usercat = finance_db_fetch_array($user);

    if (
        is_array($usercat)
        && isset($usercat['password'], $usercat['user_category'])
        && finance_password_verify($plainPassword, (string) $usercat['password'])
    ) {
        finance_password_upgrade_if_needed(
            $connection,
            $username,
            $plainPassword,
            (string) $usercat['password']
        );

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
