-- ============================================================
--   mysql-queries.sql  —  Esho Desh Gori
--   All useful MySQL queries for Admin & Reporting
-- ============================================================


-- ════════════════════════════════════════════════════════════
-- SECTION 1 — DATABASE SETUP
-- ════════════════════════════════════════════════════════════

-- Create database
CREATE DATABASE IF NOT EXISTS esho_desh_gori
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE esho_desh_gori;

-- Show all tables
SHOW TABLES;

-- Describe table structures
DESCRIBE users;
DESCRIBE admins;
DESCRIBE campaigns;
DESCRIBE donations;
DESCRIBE contact_messages;


-- ════════════════════════════════════════════════════════════
-- SECTION 2 — USER QUERIES
-- ════════════════════════════════════════════════════════════

-- All registered donors (newest first)
SELECT id, name, email, phone, city, created_at
FROM users
ORDER BY created_at DESC;

-- Search donor by name or email
SELECT * FROM users
WHERE name LIKE '%রহিম%' OR email LIKE '%rahim%';

-- Total number of donors
SELECT COUNT(*) AS total_donors FROM users;

-- Donors who have donated at least once
SELECT u.id, u.name, u.email, COUNT(d.id) AS total_donations
FROM users u
INNER JOIN donations d ON d.user_id = u.id
GROUP BY u.id
ORDER BY total_donations DESC;

-- Top 10 donors by total amount
SELECT u.name, u.email, u.phone,
       COUNT(d.id)          AS donation_count,
       SUM(d.amount)        AS total_donated
FROM users u
JOIN donations d ON d.user_id = u.id
WHERE d.status = 'completed'
GROUP BY u.id
ORDER BY total_donated DESC
LIMIT 10;

-- Donors who registered but never donated
SELECT u.id, u.name, u.email, u.created_at
FROM users u
LEFT JOIN donations d ON d.user_id = u.id
WHERE d.id IS NULL;

-- Delete a specific user (use with care)
-- DELETE FROM users WHERE id = 5;


-- ════════════════════════════════════════════════════════════
-- SECTION 3 — CAMPAIGN QUERIES
-- ════════════════════════════════════════════════════════════

-- All campaigns with donation count
SELECT
  c.id,
  c.title,
  c.category,
  c.goal_amount,
  c.raised_amount,
  c.pct_funded,
  c.status,
  COUNT(d.id) AS total_donations
FROM campaigns c
LEFT JOIN donations d ON d.campaign_id = c.id
GROUP BY c.id
ORDER BY c.pct_funded DESC;

-- Only active campaigns
SELECT * FROM campaigns WHERE status = 'active' ORDER BY pct_funded DESC;

-- Campaign closest to goal
SELECT title, pct_funded, raised_amount, goal_amount
FROM campaigns
ORDER BY pct_funded DESC
LIMIT 1;

-- Campaign furthest from goal
SELECT title, pct_funded, raised_amount, goal_amount
FROM campaigns
WHERE status = 'active'
ORDER BY pct_funded ASC
LIMIT 1;

-- Update campaign raised amount and recalculate percentage
UPDATE campaigns
SET
  raised_amount = 85000,
  pct_funded    = ROUND((85000 / goal_amount) * 100)
WHERE slug = 'school-bags';

-- Add a new campaign
INSERT INTO campaigns
  (slug, title, category, icon, color, goal_amount, raised_amount, pct_funded, intro, status)
VALUES
  ('winter-blanket', 'Winter Blanket Drive', 'Relief',
   'fas fa-snowflake',
   'linear-gradient(135deg,#1a3a5c,#3b82c4)',
   80000, 0, 0,
   'Distributing blankets to poor families in winter.',
   'active');

-- Toggle campaign status (active ↔ inactive)
UPDATE campaigns
SET status = IF(status = 'active', 'inactive', 'active')
WHERE id = 3;


-- ════════════════════════════════════════════════════════════
-- SECTION 4 — DONATION QUERIES
-- ════════════════════════════════════════════════════════════

-- All donations with campaign name (newest first)
SELECT
  d.id,
  d.name         AS donor_name,
  d.phone,
  c.title        AS campaign,
  d.intention,
  d.amount,
  d.status,
  d.created_at
FROM donations d
LEFT JOIN campaigns c ON d.campaign_id = c.id
ORDER BY d.created_at DESC;

-- All donations for a specific campaign
SELECT d.name, d.amount, d.status, d.created_at
FROM donations d
JOIN campaigns c ON d.campaign_id = c.id
WHERE c.slug = 'school-bags'
ORDER BY d.created_at DESC;

-- Total amount raised (completed only)
SELECT
  SUM(amount)   AS total_raised,
  COUNT(id)     AS total_donations,
  AVG(amount)   AS avg_donation
FROM donations
WHERE status = 'completed';

-- Donations grouped by status
SELECT status, COUNT(*) AS count, SUM(amount) AS total
FROM donations
GROUP BY status;

-- Donations grouped by campaign
SELECT
  c.title,
  COUNT(d.id)   AS donations,
  SUM(d.amount) AS amount_raised
FROM donations d
JOIN campaigns c ON d.campaign_id = c.id
WHERE d.status = 'completed'
GROUP BY c.id
ORDER BY amount_raised DESC;

-- Donations grouped by intention type
SELECT intention, COUNT(*) AS count, SUM(amount) AS total
FROM donations
GROUP BY intention
ORDER BY total DESC;

-- Monthly donation summary (current year)
SELECT
  MONTH(created_at)       AS month_num,
  MONTHNAME(created_at)   AS month_name,
  COUNT(*)                AS donations,
  SUM(amount)             AS total
FROM donations
WHERE YEAR(created_at) = YEAR(CURDATE())
  AND status = 'completed'
GROUP BY MONTH(created_at)
ORDER BY month_num;

-- Daily donations for last 30 days
SELECT
  DATE(created_at)  AS day,
  COUNT(*)          AS donations,
  SUM(amount)       AS total
FROM donations
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
  AND status = 'completed'
GROUP BY DATE(created_at)
ORDER BY day DESC;

-- Update donation status to completed
UPDATE donations SET status = 'completed' WHERE id = 12;

-- Donations above a certain amount
SELECT * FROM donations
WHERE amount >= 5000
ORDER BY amount DESC;

-- Donations from a specific city
SELECT name, phone, amount, status, created_at
FROM donations
WHERE city = 'Dhaka'
ORDER BY created_at DESC;

-- Search donation by donor phone
SELECT d.*, c.title AS campaign
FROM donations d
LEFT JOIN campaigns c ON d.campaign_id = c.id
WHERE d.phone = '01712345678';


-- ════════════════════════════════════════════════════════════
-- SECTION 5 — CONTACT MESSAGE QUERIES
-- ════════════════════════════════════════════════════════════

-- All messages (unread first)
SELECT * FROM contact_messages
ORDER BY is_read ASC, created_at DESC;

-- Count unread messages
SELECT COUNT(*) AS unread FROM contact_messages WHERE is_read = 0;

-- All unread messages
SELECT id, name, email, phone, message, created_at
FROM contact_messages
WHERE is_read = 0
ORDER BY created_at DESC;

-- Mark a message as read
UPDATE contact_messages SET is_read = 1 WHERE id = 7;

-- Mark ALL messages as read
UPDATE contact_messages SET is_read = 1;

-- Delete a specific message
-- DELETE FROM contact_messages WHERE id = 5;

-- Messages from last 7 days
SELECT * FROM contact_messages
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
ORDER BY created_at DESC;

-- Search by sender email
SELECT * FROM contact_messages
WHERE email LIKE '%gmail.com%';


-- ════════════════════════════════════════════════════════════
-- SECTION 6 — ADMIN QUERIES
-- ════════════════════════════════════════════════════════════

-- View all admins
SELECT id, name, email, role, created_at FROM admins;

-- Add a new admin
-- Password below = 'NewPass@456'  (replace hash using: php -r "echo password_hash('YourPassword', PASSWORD_BCRYPT);")
INSERT INTO admins (name, email, password, role)
VALUES ('Karim Admin', 'karim@eshodeshgori.com',
        '$2y$12$REPLACE_WITH_REAL_HASH_HERE', 'editor');

-- Change admin role
UPDATE admins SET role = 'super_admin' WHERE email = 'karim@eshodeshgori.com';

-- Delete an admin
-- DELETE FROM admins WHERE id = 3;

-- Change admin password (generate hash first in PHP)
-- UPDATE admins SET password = '$2y$12$NEW_HASH_HERE' WHERE id = 1;


-- ════════════════════════════════════════════════════════════
-- SECTION 7 — DASHBOARD SUMMARY QUERY (single query)
-- ════════════════════════════════════════════════════════════

SELECT
  (SELECT COUNT(*)                          FROM users)                                         AS total_donors,
  (SELECT COUNT(*)                          FROM donations)                                     AS total_donations,
  (SELECT COALESCE(SUM(amount), 0)          FROM donations WHERE status = 'completed')          AS total_raised,
  (SELECT COUNT(*)                          FROM campaigns WHERE status = 'active')             AS active_campaigns,
  (SELECT COUNT(*)                          FROM contact_messages WHERE is_read = 0)            AS unread_messages,
  (SELECT COUNT(*)                          FROM donations WHERE status = 'pending')            AS pending_donations,
  (SELECT COALESCE(AVG(amount), 0)          FROM donations WHERE status = 'completed')         AS avg_donation,
  (SELECT title                             FROM campaigns ORDER BY pct_funded DESC LIMIT 1)   AS top_campaign;


-- ════════════════════════════════════════════════════════════
-- SECTION 8 — REPORTING QUERIES
-- ════════════════════════════════════════════════════════════

-- Campaign performance report
SELECT
  c.title,
  c.category,
  c.goal_amount,
  c.raised_amount,
  c.pct_funded,
  COUNT(d.id)                               AS total_donations,
  COALESCE(SUM(d.amount),0)                 AS actual_raised,
  COALESCE(AVG(d.amount),0)                 AS avg_donation
FROM campaigns c
LEFT JOIN donations d ON d.campaign_id = c.id AND d.status = 'completed'
GROUP BY c.id
ORDER BY c.pct_funded DESC;

-- Donor retention — donors who donated more than once
SELECT
  name, phone, email,
  COUNT(*) AS times_donated,
  SUM(amount) AS total_given
FROM donations
WHERE status = 'completed'
GROUP BY phone
HAVING times_donated > 1
ORDER BY total_given DESC;

-- Revenue by category
SELECT
  c.category,
  COUNT(d.id)       AS donations,
  SUM(d.amount)     AS total
FROM donations d
JOIN campaigns c ON d.campaign_id = c.id
WHERE d.status = 'completed'
GROUP BY c.category
ORDER BY total DESC;

-- Full donor profile (join users + donations)
SELECT
  u.name, u.email, u.phone, u.city,
  COUNT(d.id)                AS donations,
  COALESCE(SUM(d.amount), 0) AS total_donated,
  MAX(d.created_at)          AS last_donation
FROM users u
LEFT JOIN donations d ON d.user_id = u.id AND d.status = 'completed'
GROUP BY u.id
ORDER BY total_donated DESC;
