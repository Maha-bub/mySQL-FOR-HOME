<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['admin_role']);
session_destroy();
header('Location: ' . BASE_URL . '/auth/admin-login.php');
exit;
