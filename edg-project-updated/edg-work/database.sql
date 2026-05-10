-- ============================================================
--  database.sql  —  Esho Desh Gori  (Full Web App Schema)
--  Run:  mysql -u root -p esho_desh_gori < database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS esho_desh_gori
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE esho_desh_gori;

CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(120)    NOT NULL,
    email      VARCHAR(180)    NOT NULL UNIQUE,
    phone      VARCHAR(20)     NOT NULL,
    city       VARCHAR(80)     DEFAULT '',
    address    VARCHAR(255)    DEFAULT '',
    password   VARCHAR(255)    NOT NULL,
    created_at TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admins (
    id         INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(120)    NOT NULL,
    email      VARCHAR(180)    NOT NULL UNIQUE,
    password   VARCHAR(255)    NOT NULL,
    role       ENUM('super_admin','editor') DEFAULT 'editor',
    created_at TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS campaigns (
    id            INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    slug          VARCHAR(100)    NOT NULL UNIQUE,
    title         VARCHAR(150)    NOT NULL,
    category      VARCHAR(80)     NOT NULL,
    icon          VARCHAR(100)    NOT NULL DEFAULT 'fas fa-heart',
    color         VARCHAR(200)    DEFAULT '#1a7a4a',
    goal_amount   DECIMAL(12,2)   NOT NULL DEFAULT 0,
    raised_amount DECIMAL(12,2)   NOT NULL DEFAULT 0,
    pct_funded    INT             NOT NULL DEFAULT 0,
    intro         TEXT,
    status        ENUM('active','inactive') DEFAULT 'active',
    created_at    TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS donations (
    id          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED    DEFAULT NULL,
    campaign_id INT UNSIGNED    DEFAULT NULL,
    project     VARCHAR(100)    NOT NULL,
    intention   VARCHAR(50)     NOT NULL,
    name        VARCHAR(120)    NOT NULL,
    phone       VARCHAR(20)     NOT NULL,
    city        VARCHAR(80)     NOT NULL,
    address     VARCHAR(255)    NOT NULL,
    amount      DECIMAL(10,2)   NOT NULL,
    status      ENUM('pending','completed','failed') DEFAULT 'pending',
    ip_address  VARCHAR(45)     DEFAULT NULL,
    created_at  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)     REFERENCES users(id)     ON DELETE SET NULL,
    FOREIGN KEY (campaign_id) REFERENCES campaigns(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id         INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(120)    NOT NULL,
    email      VARCHAR(180)    NOT NULL,
    phone      VARCHAR(20)     NOT NULL,
    gender     VARCHAR(10)     NOT NULL,
    address    VARCHAR(255)    NOT NULL,
    message    TEXT            NOT NULL,
    is_read    TINYINT(1)      DEFAULT 0,
    ip_address VARCHAR(45)     DEFAULT NULL,
    created_at TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Campaigns seed data ──────────────────────────────────────
INSERT IGNORE INTO campaigns (slug,title,category,icon,color,goal_amount,raised_amount,pct_funded,intro) VALUES
('school-bags','School Bags','Education','fas fa-backpack','linear-gradient(135deg,#1a3a5c,#3b82c4)',100000,72000,72,'Providing school bags and stationery to underprivileged children.'),
('build-a-masjid','Build a Masjid','Faith','fas fa-mosque','linear-gradient(135deg,#2d1a5c,#7c3aed)',300000,240000,80,'Helping build a masjid for a rural community.'),
('donate-a-house','Donate a House','Shelter','fas fa-house','linear-gradient(135deg,#4a1a0a,#c06520)',200000,96000,48,'Providing shelter to homeless families.'),
('donate-a-quran','Donate a Quran','Quran','fas fa-book-open','linear-gradient(135deg,#1a1a4a,#4f46e5)',50000,33000,66,'Distributing Quran to those who cannot afford one.'),
('emergency-aid','Emergency Aid','Emergency','fas fa-hand-holding-heart','linear-gradient(135deg,#4a0a1a,#e11d48)',100000,85000,85,'Rapid relief for families in crisis.'),
('feed-daily','Feed Daily','Food','fas fa-bowl-food','linear-gradient(135deg,#1a3a10,#4a8c20)',100000,77000,77,'Daily food distribution for the hungry.'),
('gift-of-water','Tubewell / Gift of Water','Water','fas fa-droplet','linear-gradient(135deg,#0c3d4a,#0891b2)',50000,45000,90,'Installing tubewells in water-scarce villages.'),
('healing-bangladesh','Healing Bangladesh','Healthcare','fas fa-heart-pulse','linear-gradient(135deg,#0a3d3a,#0d9488)',100000,63000,63,'Free medical camps and medicine distribution.'),
('income-generating','Income Generating','Livelihood','fas fa-seedling','linear-gradient(135deg,#1a5c2e,#4caf73)',100000,55000,55,'Skill training and small business support.'),
('sponsor-yateem','Sponsored A Yateem','Orphan','fas fa-child','linear-gradient(135deg,#3a1a10,#c05020)',100000,60000,60,'Monthly sponsorship for orphaned children.');

-- ── Default Super Admin ──────────────────────────────────────
-- Email:    mdmahabubulalam0511@gmail.com
-- Password: mahabub255238
INSERT IGNORE INTO admins (name, email, password, role) VALUES
(
  'Mahabubul Alam',
  'mdmahabubulalam0511@gmail.com',
  '$2y$12$IdVq3cjg0C2wBa/CBm5YSeSA5Ojj5gqSXI/CWT5kn6fH3f5Nt70Fa',
  'super_admin'
);
