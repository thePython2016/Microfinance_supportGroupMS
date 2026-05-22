<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "connection.php";
require_once dirname(__DIR__) . "/includes/auth.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $plainPassword = $_POST['password'] ?? '';

    if ($username === '' || $plainPassword === '') {
        header("Location:index.php");
        exit;
    }

    $username = finance_db_escape($conn, $username);

    $selectuser = "SELECT username, password, user_category FROM profile WHERE username='$username' LIMIT 1";
    $user = finance_db_query($conn, $selectuser);
    $usercat = finance_db_fetch_array($user);

    if (
        is_array($usercat)
        && isset($usercat['password'], $usercat['user_category'])
        && finance_password_verify($plainPassword, (string) $usercat['password'])
    ) {
        finance_password_upgrade_if_needed(
            $conn,
            $username,
            $plainPassword,
            (string) $usercat['password']
        );

        $returncat = (int) $usercat['user_category'];
        $_SESSION['username'] = $username;

        if ($returncat === 1) {
            header("Location:../admin/admin.php");
            exit;
        }
    }

    header("Location:index.php");
    exit;
}
