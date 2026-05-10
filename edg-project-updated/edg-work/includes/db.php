<?php
/* ============================================================
   includes/db.php — DB Connection + BASE_URL (Apache safe)
   ============================================================ */
if (!defined('BASE_URL')) {
    /* Works for: localhost/edg-project/, live domain root, any subfolder */
    $docRoot  = rtrim(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])), '/');
    $projRoot = rtrim(str_replace('\\', '/', realpath(__DIR__ . '/..')), '/');
    define('BASE_URL', str_replace($docRoot, '', $projRoot));
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'esho_desh_gori');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER, DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    http_response_code(503);
    die('<h3 style="font-family:sans-serif;color:#c0392b;padding:20px;">
        Database connection failed. Please check db.php credentials.</h3>');
}
