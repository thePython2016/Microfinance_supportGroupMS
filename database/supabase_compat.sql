-- Compatibility layer: views + missing tables for the legacy PHP app.

ALTER TABLE members ADD COLUMN IF NOT EXISTS email VARCHAR(120);

CREATE OR REPLACE VIEW app_members AS
SELECT
    mobilenumber AS "mobileNumber",
    nin,
    COALESCE(email, '') AS email,
    fname,
    mname,
    lname,
    day::text AS day,
    month::text AS month,
    year::text AS year,
    gender,
    address
FROM members;

CREATE OR REPLACE VIEW app_shares AS
SELECT
    s.id::varchar AS "shareID",
    s.share_date AS "date",
    m.mobilenumber AS member,
    s.amount
FROM shares s
JOIN members m ON m.id = s.member_id;

CREATE OR REPLACE VIEW app_loans AS
SELECT
    l.id::varchar AS "loanID",
    l.loan_date AS "date",
    m.mobilenumber AS member,
    l.amount,
    l.interest_rate AS interest
FROM loans l
JOIN members m ON m.id = l.member_id;

CREATE TABLE IF NOT EXISTS loanpayments (
    paymentid VARCHAR(50) PRIMARY KEY,
    payment_date DATE,
    member_phone VARCHAR(20),
    amount NUMERIC(15, 2)
);
