<?php
// =============================================
//  db.php — Database Connection
// =============================================

$host     = "localhost";
$username = "root";
$password = "";
$database = "product_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("
    <div style='font-family:sans-serif;padding:40px;background:#13131c;color:#f54b4b;border:1px solid #f54b4b;margin:40px;border-radius:12px;'>
        <h2>❌ Database Connection Failed</h2>
        <p style='margin-top:10px;color:#dddde8;'>" . mysqli_connect_error() . "</p>
        <hr style='border-color:#252535;margin:20px 0;'>
        <ol style='color:#6e6e8a;line-height:2;'>
            <li>Open XAMPP Control Panel</li>
            <li>Start <strong style='color:#dddde8;'>Apache</strong> and <strong style='color:#dddde8;'>MySQL</strong></li>
            <li>Go to <code style='color:#7c6dfa;'>http://localhost/phpmyadmin</code></li>
            <li>Create database: <code style='color:#7c6dfa;'>product_db</code></li>
        </ol>
    </div>
    ");
}

mysqli_set_charset($conn, "utf8");
?>
