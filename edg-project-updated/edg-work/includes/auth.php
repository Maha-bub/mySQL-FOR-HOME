<?php
/* ============================================================
   includes/auth.php — Session + Auth Helpers
   ============================================================ */
if (session_status() === PHP_SESSION_NONE) session_start();

if (!defined('BASE_URL')) require_once __DIR__ . '/db.php';

/* ─────────────────────────────────
   DONOR helpers
   ───────────────────────────────── */
function donor_logged_in(): bool { return !empty($_SESSION['donor_id']); }
function donor_id(): ?int        { return $_SESSION['donor_id'] ?? null; }
function donor_name(): string    { return $_SESSION['donor_name'] ?? 'Guest'; }
function donor_email(): string   { return $_SESSION['donor_email'] ?? ''; }

/* ─────────────────────────────────
   GUEST helpers
   ───────────────────────────────── */
function guest_allowed(): bool   { return !empty($_SESSION['guest_access']); }
function set_guest_access(): void {
    $_SESSION['guest_access'] = true;
    $_SESSION['guest_name']   = 'Guest';
}

/* ─────────────────────────────────
   Access check
   Allows BOTH registered donors AND guests
   ───────────────────────────────── */
function require_access(): void {
    if (!donor_logged_in() && !guest_allowed()) {
        $next = urlencode($_SERVER['REQUEST_URI']);
        header('Location: ' . BASE_URL . '/auth/login.php?next=' . $next);
        exit;
    }
}

/* Legacy alias — keeps all existing pages working */
function require_donor_login(): void { require_access(); }

/* ─────────────────────────────────
   ADMIN helpers
   ───────────────────────────────── */
function admin_logged_in(): bool { return !empty($_SESSION['admin_id']); }
function admin_id(): ?int        { return $_SESSION['admin_id'] ?? null; }
function admin_name(): string    { return $_SESSION['admin_name'] ?? 'Admin'; }
function admin_role(): string    { return $_SESSION['admin_role'] ?? 'editor'; }

function require_admin_login(): void {
    if (!admin_logged_in()) {
        header('Location: ' . BASE_URL . '/auth/admin-login.php');
        exit;
    }
}

/* ─────────────────────────────────
   CSRF helpers
   ───────────────────────────────── */
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_verify(): bool {
    return isset($_SESSION['csrf'], $_POST['csrf_token'])
        && hash_equals($_SESSION['csrf'], $_POST['csrf_token']);
}

/* ─────────────────────────────────
   Flash messages
   ───────────────────────────────── */
function flash_set(string $type, string $msg): void {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}
function flash_get(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
