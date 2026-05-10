<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (donor_logged_in() || guest_allowed()) {
    header('Location: ' . BASE_URL . '/');
    exit;
}

$flash  = flash_get();
$error  = '';
$mode   = $_GET['mode'] ?? '';   // '' = choice screen | 'login' = login form
$next   = $_GET['next'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) { http_response_code(403); die('Invalid token.'); }
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        $error = 'Both fields are required.';
        $mode  = 'login';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['donor_id']    = $user['id'];
            $_SESSION['donor_name']  = $user['name'];
            $_SESSION['donor_email'] = $user['email'];
            $go = (!empty($next) && str_starts_with($next, '/')) ? $next : BASE_URL . '/';
            header('Location: ' . $go); exit;
        } else {
            $error = 'Invalid email or password.';
            $mode  = 'login';
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
<title>Welcome — Esho Desh Gori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root { --green:#1a7a4a; --green-dk:#0f5432; --gold:#d4a017; --gold-lt:#f9e49a; }
*, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }

body {
  min-height:100vh;
  background: linear-gradient(150deg, #071a0e 0%, #0f5432 45%, #1a7a4a 100%);
  display:flex; align-items:center; justify-content:center;
  padding:2rem 1rem; font-family:'Segoe UI',sans-serif;
  position:relative; overflow:hidden;
}

/* Background decorative circles */
body::before {
  content:''; position:fixed; top:-120px; right:-120px;
  width:420px; height:420px; border-radius:50%;
  border:1px solid rgba(255,255,255,.05); pointer-events:none;
}
body::after {
  content:''; position:fixed; bottom:-80px; left:-80px;
  width:300px; height:300px; border-radius:50%;
  border:1px solid rgba(255,255,255,.04); pointer-events:none;
}

.wrapper { width:100%; max-width:480px; position:relative; z-index:1; }

/* ── Brand header ── */
.brand {
  text-align:center; margin-bottom:28px; color:#fff;
}
.brand-logo {
  width:64px; height:64px; border-radius:50%;
  background:rgba(255,255,255,.12);
  border:2px solid rgba(255,255,255,.20);
  display:flex; align-items:center; justify-content:center;
  font-size:26px; margin:0 auto 14px;
  box-shadow:0 4px 24px rgba(0,0,0,.30);
}
.brand-name {
  font-size:22px; font-weight:700; letter-spacing:.5px;
}
.brand-tag {
  font-size:12px; opacity:.60; letter-spacing:1px;
  text-transform:uppercase; margin-top:3px;
}

/* ── Main card ── */
.card-box {
  background:#fff; border-radius:24px;
  box-shadow:0 24px 80px rgba(0,0,0,.35);
  overflow:hidden;
}

/* ── Choice screen ── */
.choice-header {
  background:linear-gradient(135deg,var(--green-dk),var(--green));
  padding:28px 32px 24px; color:#fff; text-align:center;
}
.choice-header h2 { font-size:22px; font-weight:700; margin-bottom:4px; }
.choice-header p  { font-size:13px; opacity:.72; }

.choice-body { padding:28px 28px 32px; }

.option-cards { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px; }

.option-card {
  border-radius:16px; padding:24px 20px;
  text-align:center; cursor:pointer;
  transition:all .22s; text-decoration:none;
  display:flex; flex-direction:column;
  align-items:center; gap:12px;
  border:2px solid transparent;
}

/* Option 1 — Register/Login */
.option-card.opt-account {
  background:#e8f5ee;
  border-color:#b8ddc8;
}
.option-card.opt-account:hover {
  background:#1a7a4a; border-color:#1a7a4a;
  transform:translateY(-4px);
  box-shadow:0 12px 32px rgba(26,122,74,.35);
}
.option-card.opt-account:hover .opt-icon,
.option-card.opt-account:hover .opt-title,
.option-card.opt-account:hover .opt-desc {
  color:#fff;
}

/* Option 2 — Guest */
.option-card.opt-guest {
  background:#fef9ec;
  border-color:#f0d98a;
}
.option-card.opt-guest:hover {
  background:var(--gold); border-color:var(--gold);
  transform:translateY(-4px);
  box-shadow:0 12px 32px rgba(212,160,23,.35);
}
.option-card.opt-guest:hover .opt-icon,
.option-card.opt-guest:hover .opt-title,
.option-card.opt-guest:hover .opt-desc {
  color:#1a1a1a;
}

.opt-icon {
  font-size:30px; transition:color .22s;
}
.opt-account .opt-icon { color:var(--green); }
.opt-guest   .opt-icon { color:#b8860b; }

.opt-title {
  font-size:15px; font-weight:700; transition:color .22s;
}
.opt-account .opt-title { color:#0f5432; }
.opt-guest   .opt-title { color:#92400e; }

.opt-desc {
  font-size:12px; line-height:1.45; transition:color .22s;
}
.opt-account .opt-desc { color:#4a7a5a; }
.opt-guest   .opt-desc { color:#78490a; }

.opt-badge {
  display:inline-block; font-size:10px; font-weight:700;
  padding:3px 10px; border-radius:20px;
  letter-spacing:.8px; text-transform:uppercase;
}
.opt-account .opt-badge { background:#d1fae5; color:#065f46; }
.opt-guest   .opt-badge { background:#fde68a; color:#92400e; }

/* Divider between options */
.choice-divider {
  text-align:center; font-size:12px; color:#9ca3af;
  margin:4px 0 8px; position:relative;
}
.choice-divider::before, .choice-divider::after {
  content:''; position:absolute; top:50%;
  width:40%; height:1px; background:#e5e7eb;
}
.choice-divider::before { left:0; }
.choice-divider::after  { right:0; }

.admin-hint {
  text-align:center; font-size:12px; color:#9ca3af;
  padding-top:16px; border-top:1px solid #f3f4f6;
}
.admin-hint a { color:var(--green); font-weight:600; text-decoration:none; }

/* ── Login form screen ── */
.login-header {
  background:linear-gradient(135deg,var(--green-dk),var(--green));
  padding:24px 32px 20px; color:#fff;
  display:flex; align-items:center; gap:14px;
}
.back-btn {
  width:36px; height:36px; border-radius:50%;
  background:rgba(255,255,255,.15); border:none;
  color:#fff; cursor:pointer; font-size:14px;
  display:flex; align-items:center; justify-content:center;
  transition:background .2s; flex-shrink:0;
  text-decoration:none;
}
.back-btn:hover { background:rgba(255,255,255,.25); color:#fff; }
.login-header-text h2 { font-size:20px; font-weight:700; margin:0 0 2px; }
.login-header-text p  { font-size:12px; opacity:.70; margin:0; }

.login-body { padding:28px 32px 32px; }

.form-label { font-size:13px; font-weight:600; color:#374151; margin-bottom:4px; display:block; }
.form-control {
  width:100%; border-radius:10px;
  border:1.5px solid #d1e8d9; font-size:14px;
  padding:11px 14px; outline:none; transition:border-color .2s, box-shadow .2s;
  font-family:inherit;
}
.form-control:focus {
  border-color:var(--green);
  box-shadow:0 0 0 3px rgba(26,122,74,.12);
}
.btn-login {
  width:100%; background:var(--green); color:#fff;
  border:none; border-radius:30px; padding:13px;
  font-size:15px; font-weight:700; cursor:pointer;
  transition:all .2s; display:flex; align-items:center;
  justify-content:center; gap:8px;
  box-shadow:0 4px 16px rgba(26,122,74,.35);
}
.btn-login:hover { background:var(--green-dk); transform:translateY(-1px); }
.register-link {
  text-align:center; font-size:13px; color:#6b7280;
  margin-top:18px;
}
.register-link a { color:var(--green); font-weight:600; text-decoration:none; }

.alert-error {
  background:#fff5f5; border:1px solid #f5c6cb;
  border-radius:10px; padding:10px 14px;
  font-size:13px; color:#c0392b; margin-bottom:18px;
}
.alert-success {
  background:#e8f5ee; border:1px solid #a8d5b8;
  border-radius:10px; padding:10px 14px;
  font-size:13px; color:#0f5432; margin-bottom:18px;
}

@media (max-width:480px) {
  .option-cards { grid-template-columns:1fr; }
  .choice-body  { padding:20px 20px 24px; }
  .login-body   { padding:20px 20px 24px; }
  .login-header { padding:20px 20px 18px; }
}
</style>
</head>
<body>
<div class="wrapper">

  <!-- Brand -->
  <div class="brand">
    <div class="brand-logo"><i class="fas fa-hands-holding-heart"></i></div>
    <div class="brand-name">Esho Desh Gori</div>
    <div class="brand-tag">এসো দেশ গড়ি</div>
  </div>

  <div class="card-box">

    <?php if ($mode === 'login'): ?>
    <!-- ════════════════════════════════
         LOGIN FORM
    ════════════════════════════════ -->
    <div class="login-header">
      <a href="<?= $base ?>/auth/login.php<?= $next ? '?next='.urlencode($next) : '' ?>"
         class="back-btn" title="Back">
        <i class="fas fa-arrow-left"></i>
      </a>
      <div class="login-header-text">
        <h2>Login to Your Account</h2>
        <p>Enter your credentials to continue</p>
      </div>
    </div>

    <div class="login-body">
      <?php if ($flash): ?>
        <div class="alert-<?= $flash['type']==='success'?'success':'error' ?>">
          <i class="fas fa-<?= $flash['type']==='success'?'check-circle':'exclamation-circle' ?> me-1"></i>
          <?= htmlspecialchars($flash['msg']) ?>
        </div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert-error">
          <i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <?php if ($next): ?><input type="hidden" name="next" value="<?= htmlspecialchars($next) ?>"><?php endif; ?>
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control"
                 placeholder="your@email.com" autofocus required>
        </div>
        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control"
                 placeholder="Your password" required>
        </div>
        <button type="submit" class="btn-login">
          <i class="fas fa-right-to-bracket"></i> Login
        </button>
      </form>

      <div class="register-link">
        Don't have an account?
        <a href="<?= $base ?>/auth/register.php">Register here</a>
      </div>
    </div>

    <?php else: ?>
    <!-- ════════════════════════════════
         CHOICE SCREEN (default)
    ════════════════════════════════ -->
    <div class="choice-header">
      <h2>How would you like to continue?</h2>
      <p>Choose an option to access the website</p>
    </div>

    <div class="choice-body">
      <?php if ($flash): ?>
        <div class="alert-<?= $flash['type']==='success'?'success':'error' ?>"
             style="margin-bottom:18px;">
          <?= htmlspecialchars($flash['msg']) ?>
        </div>
      <?php endif; ?>

      <div class="option-cards">

        <!-- Option 1 — With Account -->
        <a href="<?= $base ?>/auth/login.php?mode=login<?= $next ? '&next='.urlencode($next) : '' ?>"
           class="option-card opt-account">
          <i class="fas fa-user-circle opt-icon"></i>
          <div>
            <div class="opt-title">Login / Register</div>
            <div class="opt-desc">Access your account, track donations &amp; history</div>
          </div>
          <span class="opt-badge">Full Access</span>
        </a>

        <!-- Option 2 — Guest -->
        <a href="<?= $base ?>/auth/guest.php<?= $next ? '?next='.urlencode($next) : '' ?>"
           class="option-card opt-guest">
          <i class="fas fa-user-secret opt-icon"></i>
          <div>
            <div class="opt-title">Browse as Guest</div>
            <div class="opt-desc">Explore the site without creating an account</div>
          </div>
          <span class="opt-badge">Limited</span>
        </a>

      </div>

      <!-- Quick register link -->
      <div style="text-align:center; font-size:13px; color:#6b7280; margin-bottom:16px;">
        New here? <a href="<?= $base ?>/auth/register.php" style="color:var(--green);font-weight:600;text-decoration:none;">Create a free account →</a>
      </div>

      <div class="admin-hint">
        Admin?
        <a href="<?= $base ?>/auth/admin-login.php">
          <i class="fas fa-shield-halved me-1"></i>Admin Login
        </a>
      </div>
    </div>

    <?php endif; ?>
  </div><!-- end card-box -->
</div>
</body>
</html>
