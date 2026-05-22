<?php

/**
 * Translate legacy PHP SQL to the current PostgreSQL schema.
 *
 * Base tables use lowercase column names and integer PKs (BIGSERIAL).
 * Compatibility views (app_members, app_shares, app_loans) are used for SELECTs.
 */
function finance_compat_sql(string $sql): string
{
    // Skip all DDL unchanged
    if (preg_match('/^\s*(CREATE|ALTER|DROP|GRANT|REVOKE)\s/i', $sql)) {
        return $sql;
    }

    // ── Normalise loanPayments (any case) → loanpayments ──────────────────
    $sql = preg_replace('/\bloanPayments\b/i', 'loanpayments', $sql);

    // ── Route SELECT / JOIN through compatibility views ────────────────────
    $sql = preg_replace('/\bFROM\s+members\b/i',      'FROM app_members',  $sql);
    $sql = preg_replace('/\bFROM\s+shares\b/i',       'FROM app_shares',   $sql);
    $sql = preg_replace('/\bFROM\s+loans\b/i',        'FROM app_loans',    $sql);
    $sql = preg_replace('/\bJOIN\s+members\b/i',      'JOIN app_members',  $sql);
    $sql = preg_replace('/\bJOIN\s+shares\b/i',       'JOIN app_shares',   $sql);
    $sql = preg_replace('/\bJOIN\s+loans\b/i',        'JOIN app_loans',    $sql);

    // ── mobileNumber → mobilenumber (base-table contexts only) ─────────────
    if (!preg_match('/\bapp_members\b/i', $sql)) {
        $sql = preg_replace('/\bmobileNumber\b/', 'mobilenumber', $sql);
    }

    // ── Legacy PK column aliases used across DML ───────────────────────────
    $sql = preg_replace('/\bshareID\b/',   'id',        $sql);
    $sql = preg_replace('/\bloanID\b/',    'id',        $sql);
    $sql = preg_replace('/\bpaymentID\b/', 'paymentid', $sql);

    // ══ INSERT INTO shares ══════════════════════════════════════════════════
    // Input cols:  (date, member, amount)          — id is BIGSERIAL, omit it
    // Output cols: (share_date, member_id, amount)
    if (preg_match('/\bINSERT\s+INTO\s+shares\b/i', $sql)) {
        // Strip accidental id/ shareID column if still present (keeps VALUES in sync)
        $sql = preg_replace('/\(\s*id\s*,\s*/i', '(', $sql);
        // date / "date" → share_date (column-list position)
        $sql = preg_replace('/\(\s*"?date"?\s*,/i',       '(share_date,', $sql);
        $sql = preg_replace('/\b"date"\b/',                'share_date',   $sql);
        $sql = preg_replace('/\bdate\b(?=\s*[,)])/i',     'share_date',   $sql);
        // member → member_id
        $sql = preg_replace('/,\s*member\s*,/i', ', member_id,', $sql);
        // Subselect: mobilenumber lookup → id lookup
        $sql = preg_replace(
            '/\(\s*SELECT\s+mobilenumber\s+FROM\s+members\s+WHERE\s+mobilenumber\s*=\s*\'([^\']*)\'\s*\)/i',
            "(SELECT id FROM members WHERE mobilenumber='$1')",
            $sql
        );
    }

    // ══ INSERT INTO loans ═══════════════════════════════════════════════════
    // Input cols:  (date, member, amount, interest)          — id is BIGSERIAL
    // Output cols: (loan_date, member_id, amount, interest_rate)
    if (preg_match('/\bINSERT\s+INTO\s+loans\b/i', $sql)) {
        // Strip accidental id/loanID column if present
        $sql = preg_replace('/\(\s*id\s*,\s*/i', '(', $sql);
        // date / "date" → loan_date
        $sql = preg_replace('/\(\s*"?date"?\s*,/i',       '(loan_date,', $sql);
        $sql = preg_replace('/\b"date"\b/',                'loan_date',   $sql);
        $sql = preg_replace('/\bdate\b(?=\s*[,)])/i',     'loan_date',   $sql);
        // member → member_id
        $sql = preg_replace('/,\s*member\s*,/i', ', member_id,', $sql);
        // interest → interest_rate
        $sql = preg_replace('/\binterest\b/i', 'interest_rate', $sql);
        // Subselect: mobilenumber lookup → id lookup
        $sql = preg_replace(
            '/\(\s*SELECT\s+mobilenumber\s+FROM\s+members\s+WHERE\s+mobilenumber\s*=\s*\'([^\']*)\'\s*\)/i',
            "(SELECT id FROM members WHERE mobilenumber='$1')",
            $sql
        );
    }

    // ══ INSERT INTO loanpayments ═════════════════════════════════════════════
    // Input cols:  (paymentid, date, member, amount)
    // Output cols: (paymentid, payment_date, member_phone, amount)
    // NOTE: member column stores the phone number directly (no FK lookup needed)
    if (preg_match('/\bINSERT\s+INTO\s+loanpayments\b/i', $sql)) {
        // date → payment_date (between paymentid and member)
        $sql = preg_replace('/,\s*"?date"?\s*,/i', ', payment_date,', $sql);
        // member → member_phone
        $sql = preg_replace('/,\s*member\s*,/i', ', member_phone,', $sql);
    }

    // ══ UPDATE shares — column name fixes ═══════════════════════════════════
    if (preg_match('/\bUPDATE\s+shares\b/i', $sql)) {
        $sql = preg_replace('/\bdate\b/i', 'share_date', $sql);
    }

    // ══ UPDATE loans — column name fixes ════════════════════════════════════
    if (preg_match('/\bUPDATE\s+loans\b/i', $sql)) {
        $sql = preg_replace('/\bdate\b/i',      'loan_date',    $sql);
        $sql = preg_replace('/\binterest\b/i',  'interest_rate', $sql);
    }

    // ══ UPDATE / DELETE WHERE member = '...' on base tables ═════════════════
    // Translate phone-based WHERE to member_id subselect
    if (preg_match('/\bwhere\s+member\s*=/i', $sql)
        && preg_match('/\b(UPDATE|DELETE)\b.+\b(shares|loans)\b/i', $sql)
    ) {
        $sql = preg_replace(
            '/\bWHERE\s+member\s*=\s*\'([^\']*)\'/i',
            "WHERE member_id = (SELECT id FROM members WHERE mobilenumber='$1')",
            $sql
        );
    }

    // WHERE member = '...' on views (member column already = mobilenumber string)
    if (preg_match('/\b(app_shares|app_loans)\b/i', $sql)) {
        $sql = preg_replace(
            '/\bWHERE\s+member\s*=\s*\'([^\']*)\'/i',
            "WHERE member='$1'",
            $sql
        );
    }

    // ══ DELETE FROM members WHERE mobileNumber/mobilenumber ═════════════════
    // No extra transformation needed — mobilenumber is already normalised above.

    return $sql;
}

/** @param array<string, mixed> $row */
function finance_normalize_row(array $row): array
{
    $map = [
        'mobilenumber'  => 'mobileNumber',
        'shareid'       => 'shareID',
        'loanid'        => 'loanID',
        'paymentid'     => 'paymentID',
        'interest_rate' => 'interest',
        'share_date'    => 'date',
        'loan_date'     => 'date',
        'payment_date'  => 'date',
        'member_phone'  => 'member',
        'sent_date'     => 'date',
        'count'         => 'Count',
        'total'         => 'Total',
    ];

    $normalized = [];
    foreach ($row as $key => $value) {
        $lower = strtolower((string) $key);
        $normalized[$map[$lower] ?? $key] = $value;
    }

    return $normalized;
}
