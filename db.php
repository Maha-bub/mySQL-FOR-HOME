<?php
// =============================================
//  db.php — Database Connection
//  Beginner-friendly with comments!
// =============================================

$host     = "localhost";   // Where MySQL is running
$username = "root";        // Default XAMPP username
$password = "";            // Default XAMPP password (empty)
$database = "product_db";  // The database we created

// Connect to MySQL
$conn = mysqli_connect($host, $username, $password, $database);

// Check if connection worked
if (!$conn) {
    die("
    <div style='font-family:sans-serif; padding:30px; background:#fff0f0; border:2px solid red; margin:20px; border-radius:8px;'>
        <h2>❌ Database Connection Failed!</h2>
        <p><strong>Error:</strong> " . mysqli_connect_error() . "</p>
        <hr>
        <h3>🔧 How to fix this:</h3>
        <ol>
            <li>Open <strong>XAMPP Control Panel</strong></li>
            <li>Make sure <strong>MySQL is running</strong> (green light)</li>
            <li>Make sure you created the database <code>product_db</code> in phpMyAdmin</li>
        </ol>
    </div>
    ");
}

// Set character encoding to UTF-8 (supports all languages)
mysqli_set_charset($conn, "utf8");
?>
