-- PostgreSQL schema for the finance (microfinance) application.
-- Run this in your Supabase SQL editor or via psql.

CREATE TABLE IF NOT EXISTS members (
    "mobileNumber" VARCHAR(20) PRIMARY KEY,
    nin VARCHAR(50),
    email VARCHAR(120),
    fname VARCHAR(100),
    mname VARCHAR(100),
    lname VARCHAR(100),
    day VARCHAR(2),
    month VARCHAR(20),
    year VARCHAR(4),
    gender VARCHAR(20),
    address TEXT
);

CREATE TABLE IF NOT EXISTS officers (
    "mobileNumber" VARCHAR(20) PRIMARY KEY,
    nin VARCHAR(50),
    fname VARCHAR(100),
    mname VARCHAR(100),
    lname VARCHAR(100),
    day VARCHAR(2),
    month VARCHAR(20),
    year VARCHAR(4),
    gender VARCHAR(20),
    address TEXT
);

CREATE TABLE IF NOT EXISTS shares (
    "shareID" VARCHAR(50) PRIMARY KEY,
    "date" DATE,
    member VARCHAR(20) REFERENCES members ("mobileNumber") ON DELETE CASCADE,
    amount NUMERIC(15, 2)
);

CREATE TABLE IF NOT EXISTS loans (
    "loanID" VARCHAR(50) PRIMARY KEY,
    "date" DATE,
    member VARCHAR(20) REFERENCES members ("mobileNumber") ON DELETE CASCADE,
    amount NUMERIC(15, 2),
    interest NUMERIC(15, 2)
);

CREATE TABLE IF NOT EXISTS "loanPayments" (
    "paymentID" VARCHAR(50) PRIMARY KEY,
    "date" DATE,
    member VARCHAR(20) REFERENCES members ("mobileNumber") ON DELETE CASCADE,
    amount NUMERIC(15, 2)
);

CREATE TABLE IF NOT EXISTS profile (
    username VARCHAR(100) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    user_category INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS sent_sms (
    id VARCHAR(50) PRIMARY KEY,
    "date" TIMESTAMP,
    sender_name VARCHAR(100),
    receiver_name TEXT,
    subject VARCHAR(255),
    message TEXT
);

-- Default users: run `php database/seed_profile.php` to insert bcrypt-hashed passwords.
