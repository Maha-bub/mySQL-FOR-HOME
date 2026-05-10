<?php
/* ============================================================
   auth/register.php — Donor Registration
   ============================================================ */
require_once '../includes/db.php';
require_once '../includes/auth.php';

/* Already logged in → go home */
if (donor_logged_in()) {
    header('Location: ' . BASE_URL . '/');
    exit;
}

$errors = []; $old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) { http_response_code(403); die('Invalid token.'); }

    $old['name']    = $name    = trim(strip_tags($_POST['name']    ?? ''));
    $old['email']   = $email   = trim(strip_tags($_POST['email']   ?? ''));
    $old['phone']   = $phone   = trim(strip_tags($_POST['phone']   ?? ''));
    $old['city']    = $city    = trim(strip_tags($_POST['city']    ?? ''));
    $old['address'] = $address = trim(strip_tags($_POST['address'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';

    if (empty($name))                               $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
    if (!preg_match('/^01[0-9]{9}$/', $phone))      $errors[] = 'Phone must be 01XXXXXXXXX.';
    if (strlen($password) < 6)                      $errors[] = 'Password min 6 characters.';
    if ($password !== $confirm)                     $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);
        if ($check->fetch()) {
            $errors[] = 'This email is already registered.';
        } else {
            $pdo->prepare(
                'INSERT INTO users (name,email,phone,city,address,password) VALUES (?,?,?,?,?,?)'
            )->execute([$name, $email, $phone, $city, $address, password_hash($password, PASSWORD_BCRYPT)]);

            flash_set('success', 'Account created! Please login.');
            header('Location: ' . BASE_URL . '/auth/login.php?mode=login');
            exit;
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
<title>Register — Esho Desh Gori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root { --green:#1a7a4a; --green-dk:#0f5432; --gold:#d4a017; }
*{ box-sizing:border-box; }
body {
  background: linear-gradient(135deg,#0f5432 0%,#1a7a4a 50%,#2d9e6a 100%);
  min-height:100vh; display:flex; align-items:center;
  justify-content:center; padding:2rem 1rem; font-family:'Segoe UI',sans-serif;
}
.auth-card {
  background:#fff; border-radius:20px;
  box-shadow:0 20px 60px rgba(0,0,0,.25);
  width:100%; max-width:520px; overflow:hidden;
}
.auth-top {
  background:linear-gradient(135deg,var(--green-dk),var(--green));
  padding:32px 36px 28px; color:#fff; position:relative; overflow:hidden;
}
.auth-top::after {
  content:''; position:absolute; right:-60px; top:-60px;
  width:180px; height:180px; border-radius:50%;
  border:1px solid rgba(255,255,255,.10);
}
.auth-top h1 { font-size:26px; font-weight:700; margin:0 0 4px; }
.auth-top p  { font-size:13px; opacity:.75; margin:0; }
.logo-circle {
  width:52px; height:52px; background:rgba(255,255,255,.15);
  border-radius:50%; display:flex; align-items:center;
  justify-content:center; margin-bottom:14px; font-size:22px;
}
.auth-body  { padding:32px 36px; }
.form-label { font-size:13px; font-weight:600; color:#374151; margin-bottom:4px; }
.form-control {
  border-radius:10px; border:1.5px solid #d1e8d9;
  font-size:14px; padding:10px 14px;
  transition:border-color .2s, box-shadow .2s;
}
.form-control:focus {
  border-color:var(--green);
  box-shadow:0 0 0 3px rgba(26,122,74,.12); outline:none;
}
.btn-register {
  background:var(--green); color:#fff; border:none;
  border-radius:30px; padding:13px; font-size:15px;
  font-weight:600; width:100%; cursor:pointer;
  transition:all .2s; display:flex; align-items:center;
  justify-content:center; gap:8px;
}
.btn-register:hover { background:var(--green-dk); transform:translateY(-1px); }
.divider { text-align:center; font-size:13px; color:#9ca3af; margin:18px 0 0; }
.divider a { color:var(--green); font-weight:600; text-decoration:none; }
.back-link {
  text-align:center; margin-top:10px; font-size:12px;
  color:#9ca3af;
}
.back-link a { color:#9ca3af; text-decoration:none; }
.back-link a:hover { color:var(--green); }
</style>
</head>
<body>
<div class="auth-card">

  <div class="auth-top">
    <div class="logo-circle"><i class="fas fa-hands-holding-heart"></i></div>
    <h1>Create Account</h1>
    <p>Join Esho Desh Gori and start making a difference</p>
  </div>

  <div class="auth-body">

    <?php if ($errors): ?>
      <div class="alert alert-danger py-2 px-3 mb-3" style="border-radius:10px;font-size:13px;">
        <?php foreach ($errors as $e): ?>
          <div><i class="fas fa-circle-exclamation me-1"></i><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Full Name *</label>
          <input type="text" name="name" class="form-control"
                 value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                 placeholder="Your full name" required>
        </div>
        <div class="col-12">
          <label class="form-label">Email Address *</label>
          <input type="email" name="email" class="form-control"
                 value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                 placeholder="example@email.com" required>
        </div>
        <div class="col-sm-6">
          <label class="form-label">Phone Number *</label>
          <input type="text" name="phone" class="form-control"
                 value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                 placeholder="01XXXXXXXXX" maxlength="11" required>
        </div>
        <div class="col-sm-6">
          <label class="form-label">City</label>
          <input type="text" name="city" class="form-control"
                 value="<?= htmlspecialchars($old['city'] ?? '') ?>"
                 placeholder="Dhaka">
        </div>
        <div class="col-12">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control"
                 value="<?= htmlspecialchars($old['address'] ?? '') ?>"
                 placeholder="Your full address">
        </div>
        <div class="col-sm-6">
          <label class="form-label">Password *</label>
          <input type="password" name="password" class="form-control"
                 placeholder="Minimum 6 characters" required>
        </div>
        <div class="col-sm-6">
          <label class="form-label">Confirm Password *</label>
          <input type="password" name="confirm" class="form-control"
                 placeholder="Repeat password" required>
        </div>
        <div class="col-12 mt-1">
          <button type="submit" class="btn-register">
            <i class="fas fa-user-plus"></i> Create Account
          </button>
        </div>
      </div>
    </form>

    <div class="divider">Already have an account? <a href="<?= $base ?>/auth/login.php">Login here</a></div>
    <div class="back-link"><a href="<?= $base ?>/auth/login.php"><i class="fas fa-arrow-left me-1"></i>Back to login</a></div>

  </div>
</div>
</body>
</html>
