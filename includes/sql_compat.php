<?php

/**
 * Translate legacy MySQL-style SQL to the current Supabase/PostgreSQL schema.
 */
function finance_compat_sql(string $sql): string
{
    if (preg_match('/^\s*(CREATE|ALTER|DROP|GRANT|REVOKE)\s/i', $sql)) {
        return $sql;
    }

    $fromReplacements = [
        '/\bfrom\s+members\b/i' => 'FROM app_members',
        '/\bfrom\s+shares\b/i' => 'FROM app_shares',
        '/\bfrom\s+loans\b/i' => 'FROM app_loans',
        '/\bfrom\s+loanPayments\b/i' => 'FROM loanpayments',
        '/\bfrom\s+loanpayments\b/i' => 'FROM loanpayments',
        '/\bjoin\s+shares\b/i' => 'JOIN app_shares',
        '/\bjoin\s+loans\b/i' => 'JOIN app_loans',
        '/\bjoin\s+members\b/i' => 'JOIN app_members',
        '/\bupdate\s+shares\b/i' => 'UPDATE shares',
        '/\bupdate\s+loans\b/i' => 'UPDATE loans',
        '/\bupdate\s+members\b/i' => 'UPDATE members',
        '/\bupdate\s+officers\b/i' => 'UPDATE officers',
        '/\binsert\s+into\s+shares\b/i' => 'INSERT INTO shares',
        '/\binsert\s+into\s+loans\b/i' => 'INSERT INTO loans',
        '/\binsert\s+into\s+members\b/i' => 'INSERT INTO members',
        '/\binsert\s+into\s+loanPayments\b/i' => 'INSERT INTO loanpayments',
        '/\binsert\s+into\s+loanpayments\b/i' => 'INSERT INTO loanpayments',
        '/\bdelete\s+from\s+shares\b/i' => 'DELETE FROM shares',
        '/\bdelete\s+from\s+loans\b/i' => 'DELETE FROM loans',
        '/\bdelete\s+from\s+members\b/i' => 'DELETE FROM members',
    ];

    foreach ($fromReplacements as $pattern => $replacement) {
        $sql = preg_replace($pattern, $replacement, $sql);
    }

    // Base members table uses mobilenumber; app_members view exposes "mobileNumber".
    if (!preg_match('/\bapp_members\b/i', $sql)) {
        $sql = preg_replace('/\bmobileNumber\b/', 'mobilenumber', $sql);
    }

    // Legacy share/loan inserts reference member phone; map to member_id.
    $sql = preg_replace(
        '/\(select\s+mobilenumber\s+from\s+members\s+where\s+mobilenumber=\'([^\']+)\'\)/i',
        "(SELECT id FROM members WHERE mobilenumber='$1')",
        $sql
    );

    // Legacy column names on base tables.
    $sql = preg_replace('/\bshareID\b/', 'id', $sql);
    $sql = preg_replace('/\bloanID\b/', 'id', $sql);
    $sql = preg_replace('/\bpaymentID\b/', 'paymentid', $sql);

    if (preg_match('/\binsert\s+into\s+shares\b/i', $sql)) {
        $sql = preg_replace('/\(\s*id\s*,\s*"date"\s*,/i', '(share_date,', $sql);
        $sql = preg_replace('/\(\s*id\s*,\s*date\s*,/i', '(share_date,', $sql);
        $sql = preg_replace('/,\s*member\s*,/i', ', member_id,', $sql);
        $sql = preg_replace('/\b"date"\b/', 'share_date', $sql);
        $sql = preg_replace('/\bdate\b(?=\s*,|\s*\))/i', 'share_date', $sql);
    }

    if (preg_match('/\binsert\s+into\s+loans\b/i', $sql)) {
        $sql = preg_replace('/\(\s*id\s*,\s*"date"\s*,/i', '(loan_date,', $sql);
        $sql = preg_replace('/\(\s*id\s*,\s*date\s*,/i', '(loan_date,', $sql);
        $sql = preg_replace('/,\s*member\s*,/i', ', member_id,', $sql);
        $sql = preg_replace('/\binterest\b/', 'interest_rate', $sql);
    }

    if (preg_match('/\binsert\s+into\s+loanpayments\b/i', $sql)) {
        $sql = preg_replace('/\(\s*paymentid\s*,/i', '(paymentid,', $sql);
        $sql = preg_replace('/,\s*member\s*,/i', ', member_phone,', $sql);
    }

    if (preg_match('/\bwhere\s+member\s*=/i', $sql) && preg_match('/\b(update|delete)\s+(shares|loans)\b/i', $sql)) {
        $sql = preg_replace(
            '/\bwhere\s+member\s*=\s*\'([^\']+)\'/i',
            "WHERE member_id=(SELECT id FROM members WHERE mobilenumber='$1')",
            $sql
        );
    }

    if (preg_match('/\bapp_shares\b/i', $sql)) {
        $sql = preg_replace('/\bwhere\s+member\s*=\s*\'([^\']+)\'/i', "WHERE member='$1'", $sql);
    }

    return $sql;
}

/** @param array<string, mixed> $row */
function finance_normalize_row(array $row): array
{
    $map = [
        'mobilenumber' => 'mobileNumber',
        'shareid' => 'shareID',
        'loanid' => 'loanID',
        'paymentid' => 'paymentID',
        'interest_rate' => 'interest',
        'share_date' => 'date',
        'loan_date' => 'date',
        'member_phone' => 'member',
        'count' => 'Count',
        'total' => 'Total',
    ];

    $normalized = [];
    foreach ($row as $key => $value) {
        $lower = strtolower((string) $key);
        $normalized[$map[$lower] ?? $key] = $value;
    }

    return $normalized;
}
