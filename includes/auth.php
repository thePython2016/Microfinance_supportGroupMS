<?php

/**
 * Password helpers for profile login (bcrypt via password_hash / password_verify).
 */

function finance_password_hash(string $plainPassword): string
{
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

function finance_password_is_hashed(string $stored): bool
{
    return password_get_info($stored)['algo'] !== 0;
}

function finance_password_verify(string $plainPassword, string $stored): bool
{
    if ($stored === '') {
        return false;
    }

    if (finance_password_is_hashed($stored)) {
        return password_verify($plainPassword, $stored);
    }

    // Legacy row: plain-text password still in the database.
    return hash_equals($stored, $plainPassword);
}

function finance_password_should_rehash(string $stored): bool
{
    if (!finance_password_is_hashed($stored)) {
        return true;
    }

    return password_needs_rehash($stored, PASSWORD_DEFAULT);
}

/**
 * After a successful login, store a bcrypt hash if the row still has plain text.
 */
function finance_password_upgrade_if_needed($connection, string $username, string $plainPassword, string $stored): void
{
    if (!finance_password_should_rehash($stored)) {
        return;
    }

    $hash = finance_password_hash($plainPassword);
    $username = finance_db_escape($connection, $username);
    $hash = finance_db_escape($connection, $hash);

    finance_db_query(
        $connection,
        "UPDATE profile SET password='$hash' WHERE username='$username'"
    );
}
