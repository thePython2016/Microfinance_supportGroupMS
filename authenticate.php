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

    $usernameEsc = finance_db_escape($connection, $username);

    $selectuser = "SELECT username, password, level FROM account WHERE username='$usernameEsc' LIMIT 1";
    $user = finance_db_query($connection, $selectuser);
    $row = finance_db_fetch_array($user);

    if (
        is_array($row)
        && isset($row['password'], $row['level'])
        && finance_password_verify($plainPassword, (string) $row['password'])
    ) {
        finance_password_upgrade_if_needed(
            $connection,
            $username,
            $plainPassword,
            (string) $row['password'],
            'account'
        );

        $level = (int) $row['level'];
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $level;

        if ($level === 1) {
            header("Location:admin/admin.php");
            exit;
        }
        if ($level === 2) {
            header("Location:member/macro-member.php");
            exit;
        }
    }

    $_SESSION['login_error'] = 'Invalid username or password.';
    header("Location:index.php");
    exit;
}
