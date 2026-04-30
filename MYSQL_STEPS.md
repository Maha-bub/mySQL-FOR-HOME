# 🗄️ MySQL Setup Steps for Beginners

## ✅ STEP 1 — Install XAMPP (Easiest for Beginners)

1. Go to: https://www.apachefriends.org/download.html
2. Download **XAMPP for Windows**
3. Install it → keep all defaults
4. Open **XAMPP Control Panel**
5. Click **Start** next to **Apache** and **MySQL**
6. Both should turn GREEN ✅

---

## ✅ STEP 2 — Open phpMyAdmin

1. Open your browser
2. Go to: `http://localhost/phpmyadmin`
3. You are now inside MySQL (no password needed by default)

---

## ✅ STEP 3 — Create the Database

Click the **SQL** tab at the top and paste this:

```sql
CREATE DATABASE product_db;
```

Then click **Go** ▶️

---

## ✅ STEP 4 — Create the Table

Click on **product_db** in the left sidebar.
Then click **SQL** tab again and paste this:

```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Click **Go** ▶️

---

## ✅ STEP 5 — Insert Sample Data (Optional but Recommended)

```sql
INSERT INTO products (name, category, price, quantity, description, image) VALUES
('Wireless Headphones', 'Electronics', 2500.00, 15, 'High quality Bluetooth headphones with noise cancellation', ''),
('Leather Wallet', 'Accessories', 850.00, 30, 'Genuine leather slim wallet with card slots', ''),
('Mechanical Keyboard', 'Electronics', 4200.00, 8, 'RGB mechanical keyboard with blue switches', ''),
('Running Shoes', 'Footwear', 3100.00, 20, 'Lightweight running shoes with cushioned sole', ''),
('Coffee Mug', 'Kitchen', 350.00, 50, 'Ceramic mug 350ml, microwave safe', '');
```

Click **Go** ▶️

---

## ✅ STEP 6 — Put Your Project in XAMPP Folder

1. Copy your **product_manager** folder
2. Paste it inside: `C:\xampp\htdocs\`
3. Final path: `C:\xampp\htdocs\product_manager\`

---

## ✅ STEP 7 — Run the Project

Open browser → go to:
```
http://localhost/product_manager/index.php
```

🎉 Done! Your project is running!

---

## 🔑 Database Connection Info (for db.php)

| Setting  | Value         |
|----------|---------------|
| Host     | localhost     |
| Username | root          |
| Password | (empty)       |
| Database | product_db    |

---

## 💡 Common Errors & Fixes

| Error | Fix |
|-------|-----|
| "Connection refused" | Start MySQL in XAMPP Control Panel |
| "Access denied" | Make sure username is `root` and password is empty |
| "Table doesn't exist" | Run the CREATE TABLE SQL again |
| "uploads folder error" | Right-click uploads folder → Properties → uncheck Read-only |
