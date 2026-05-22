-- Compatibility views for the legacy PHP app.
-- These views translate base-table column names to the names the PHP code expects.
-- Run this after postgres_schema.sql (install_schema.php does both automatically).

-- Ensure email column exists (safe to re-run)
ALTER TABLE members ADD COLUMN IF NOT EXISTS email VARCHAR(120);

-- app_members: exposes mobilenumber as "mobileNumber" for legacy PHP code
CREATE OR REPLACE VIEW app_members AS
SELECT
    mobilenumber AS "mobileNumber",
    nin,
    COALESCE(email, '') AS email,
    fname,
    mname,
    lname,
    day::text                              AS day,
    month::text                            AS month,
    EXTRACT(YEAR FROM year)::int::text     AS year,
    gender,
    address
FROM members;

-- app_shares: joins shares → members to expose phone as "member"
CREATE OR REPLACE VIEW app_shares AS
SELECT
    s.id::varchar        AS "shareID",
    s.share_date         AS "date",
    m.mobilenumber       AS member,
    s.amount
FROM shares s
JOIN members m ON m.id = s.member_id;

-- app_loans: joins loans → members to expose phone as "member"
CREATE OR REPLACE VIEW app_loans AS
SELECT
    l.id::varchar        AS "loanID",
    l.loan_date          AS "date",
    m.mobilenumber       AS member,
    l.amount,
    l.interest_rate      AS interest
FROM loans l
JOIN members m ON m.id = l.member_id;
