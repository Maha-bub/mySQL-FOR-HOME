<?php
/* ============================================================
   auth/admin-login.php — Admin Login
   ============================================================ */
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (admin_logged_in()) {
    header('Location: ' . BASE_URL . '/admin/');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) { http_response_code(403); die('Invalid token.'); }

    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Both fields are required.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_role'] = $admin['role'];
            header('Location: ' . BASE_URL . '/admin/');
            exit;
        } else {
            $error = 'Invalid admin credentials.';
        }
    }
}
$base = BASE_URL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login — Esho Desh Gori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*{ box-sizing:border-box; }
body {
  background:#0d1117; min-height:100vh; display:flex;
  align-items:center; justify-content:center;
  padding:2rem 1rem; font-family:'Segoe UI',sans-serif;
}
.auth-card {
  background:#161b22; border:1px solid rgba(255,255,255,.08);
  border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.50);
  width:100%; max-width:400px; overflow:hidden;
}
.auth-top {
  background:linear-gradient(135deg,#0f5432,#1a7a4a);
  padding:32px 36px 26px; color:#fff;
}
.auth-top h1 { font-size:22px; font-weight:700; margin:0 0 4px; }
.auth-top p  { font-size:13px; opacity:.68; margin:0; }
.shield {
  width:50px; height:50px; background:rgba(255,255,255,.12);
  border-radius:50%; display:flex; align-items:center;
  justify-content:center; margin-bottom:14px; font-size:20px;
}
.auth-body { padding:28px 36px 32px; }
.form-label { font-size:13px; font-weight:600; color:#8b949e; margin-bottom:4px; }
.form-control {
  background:#0d1117; border:1.5px solid rgba(255,255,255,.12);
  border-radius:10px; color:#e6edf3; font-size:14px; padding:11px 14px;
}
.form-control:focus {
  background:#0d1117; color:#e6edf3;
  border-color:#1a7a4a; box-shadow:0 0 0 3px rgba(26,122,74,.20);
  outline:none;
}
.form-control::placeholder { color:#484f58; }
.btn-admin {
  background:#1a7a4a; color:#fff; border:none;
  border-radius:30px; padding:13px; font-size:15px;
  font-weight:700; width:100%; cursor:pointer;
  transition:all .2s; display:flex; align-items:center;
  justify-content:center; gap:8px;
}
.btn-admin:hover { background:#0f5432; }
.back-link { text-align:center; margin-top:18px; font-size:12px; }
.back-link a { color:#484f58; text-decoration:none; transition:color .2s; }
.back-link a:hover { color:#1a7a4a; }
</style>
</head>
<body>
<div class="auth-card">
  <div class="auth-top">
    <div class="shield"><i class="fas fa-shield-halved"></i></div>
    <h1>Admin Panel</h1>
    <p>Authorized personnel only</p>
  </div>
  <div class="auth-body">
    <?php if ($error): ?>
      <div class="alert py-2 px-3 mb-3"
           style="border-radius:10px;font-size:13px;background:#3b1f1f;border:1px solid #7f1d1d;color:#fca5a5;">
        <i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
      <div class="mb-3">
        <label class="form-label">Admin Email</label>
        <input type="email" name="email" class="form-control"
               placeholder="admin@eshodeshgori.com" autofocus required>
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control"
               placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-admin">
        <i class="fas fa-right-to-bracket"></i> Login to Admin Panel
      </button>
    </form>
    <div class="back-link">
      <a href="<?= $base ?>/auth/login.php"><i class="fas fa-arrow-left me-1"></i>Donor login</a>
      &nbsp;·&nbsp;
      <a href="<?= $base ?>/">Main website</a>
    </div>
  </div>
</div>
</body>
</html>
