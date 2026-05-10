<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
set_guest_access();
$next = $_GET['next'] ?? (BASE_URL . '/');
if (!str_starts_with($next, '/')) $next = BASE_URL . '/';
header('Location: ' . $next);
exit;
