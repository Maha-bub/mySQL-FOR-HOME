<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
unset($_SESSION['donor_id'], $_SESSION['donor_name'], $_SESSION['donor_email']);
session_destroy();
header('Location: ' . BASE_URL . '/auth/login.php');
exit;
