-- PostgreSQL schema for the finance (microfinance) application.
-- All identifiers are unquoted (lowercase) to avoid case-sensitivity issues.
-- Run install_schema.php to apply this file + the compat views.

CREATE TABLE IF NOT EXISTS members (
    id           BIGSERIAL PRIMARY KEY,
    mobilenumber VARCHAR(20) UNIQUE NOT NULL,
    nin          VARCHAR(50),
    email        VARCHAR(120),
    fname        VARCHAR(100),
    mname        VARCHAR(100),
    lname        VARCHAR(100),
    day          VARCHAR(2),
    month        VARCHAR(20),
    year         VARCHAR(4),
    gender       VARCHAR(20),
    address      TEXT,
    date_joined  TIMESTAMP DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS officers (
    id           BIGSERIAL PRIMARY KEY,
    mobilenumber VARCHAR(20) UNIQUE NOT NULL,
    nin          VARCHAR(50),
    fname        VARCHAR(100),
    mname        VARCHAR(100),
    lname        VARCHAR(100),
    day          VARCHAR(2),
    month        VARCHAR(20),
    year         VARCHAR(4),
    gender       VARCHAR(20),
    address      TEXT
);

CREATE TABLE IF NOT EXISTS shares (
    id          BIGSERIAL PRIMARY KEY,
    share_date  DATE,
    member_id   BIGINT REFERENCES members(id) ON DELETE CASCADE,
    amount      NUMERIC(15, 2)
);

CREATE TABLE IF NOT EXISTS loans (
    id            BIGSERIAL PRIMARY KEY,
    loan_date     DATE,
    member_id     BIGINT REFERENCES members(id) ON DELETE CASCADE,
    amount        NUMERIC(15, 2),
    interest_rate NUMERIC(15, 2)
);

CREATE TABLE IF NOT EXISTS loanpayments (
    paymentid    VARCHAR(50) PRIMARY KEY,
    payment_date DATE,
    member_phone VARCHAR(20),
    amount       NUMERIC(15, 2)
);

CREATE TABLE IF NOT EXISTS profile (
    username      VARCHAR(100) PRIMARY KEY,
    password      VARCHAR(255) NOT NULL,
    user_category INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS sent_sms (
    id            VARCHAR(50) PRIMARY KEY,
    sent_date     TIMESTAMP,
    sender_name   VARCHAR(100),
    receiver_name TEXT,
    subject       VARCHAR(255),
    message       TEXT
);
