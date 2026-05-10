<?php
/* ============================================================
   donate.php  —  DONATION PAGE
   
   GET params (passed from project pages):
     ?project=School+Bags   → pre-selects the project dropdown
     &amount=500            → pre-fills the amount field
   ============================================================ */

/* ── POST Handler ── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';

    $project   = trim(strip_tags($_POST['project']   ?? ''));
    $intention = trim(strip_tags($_POST['intention'] ?? ''));
    $name      = trim(strip_tags($_POST['name']      ?? ''));
    $phone     = trim(strip_tags($_POST['phone']     ?? ''));
    $city      = trim(strip_tags($_POST['city']      ?? ''));
    $address   = trim(strip_tags($_POST['address']   ?? ''));
    $amount    = floatval($_POST['amount'] ?? 0);
    $ip        = $_SERVER['REMOTE_ADDR'] ?? null;

    $errors = [];
    if (empty($project))                             $errors[] = 'Project is required.';
    if (empty($intention))                           $errors[] = 'Intention is required.';
    if (empty($name))                                $errors[] = 'Name is required.';
    if (!preg_match('/^01[0-9]{9}$/', $phone))       $errors[] = 'Invalid phone number.';
    if (empty($city))                                $errors[] = 'City is required.';
    if (empty($address))                             $errors[] = 'Address is required.';
    if ($amount <= 0)                                $errors[] = 'Invalid donation amount.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO donations
                (project, intention, name, phone, city, address, amount, ip_address)
            VALUES
                (:project, :intention, :name, :phone, :city, :address, :amount, :ip)
        ");
        $stmt->execute([
            ':project'   => $project,
            ':intention' => $intention,
            ':name'      => $name,
            ':phone'     => $phone,
            ':city'      => $city,
            ':address'   => $address,
            ':amount'    => $amount,
            ':ip'        => $ip,
        ]);

        header('Location: donate.php?success=1');
        exit;
    }
}

/* ── Read GET params from project pages ── */
// Sanitize before using in HTML
$pre_project = trim(strip_tags($_GET['project'] ?? ''));
$pre_amount  = floatval($_GET['amount']  ?? 0);

// After POST error: keep user's submitted values
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pre_project = $project ?? $pre_project;
    $pre_amount  = $amount  ?? $pre_amount;
}

$page_title = "Donate - Esho Desh Gori";
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_donor_login();
include 'includes/header.php';

$show_success = isset($_GET['success']);

/* All project names (must match sidebar values exactly) */
$all_projects = [
    'School Bags', 'Income Generating', 'Healing Bangladesh',
    'Donate a House', 'Build a Masjid', 'Gift of Water',
    'Donate a Quran', 'Emergency Aid', 'Feed Daily',
    'Sponsored A Yateem', 'General Fund',
];
?>

<!-- Page Hero -->
<div class="page-hero">
  <h1>Donate & <span>Make a Difference</span></h1>
  <p>Secure Online Donation Gateway</p>
</div>
<div class="page-hero-rule"></div>

<div class="section-wrap" style="background:#f0faf4;">
  <div class="donate-page-wrap">
    <div class="donate-grid">

      <!-- ── LEFT INFO PANEL ── -->
      <div class="donate-left">
        <div class="donate-panel-title">Accepted Payments</div>
        <div class="donate-panel-sub">All transactions are encrypted &amp; secure</div>

        <div class="secure-badge">
          <i class="fas fa-shield-halved"></i>
          <span>You will be redirected to a<br>secure payment gateway</span>
        </div>

        <div class="payment-label">Payment Methods</div>
        <div class="payment-list">
          <div class="payment-item">
            <div class="payment-icon">📱</div>
            <span>bKash (Online Gateway)</span>
            <div class="payment-check"></div>
          </div>
          <div class="payment-item">
            <div class="payment-icon">🚀</div>
            <span>Nagad / Rocket</span>
            <div class="payment-check"></div>
          </div>
          <div class="payment-item">
            <div class="payment-icon">💳</div>
            <span>Visa / MasterCard / AmEx</span>
            <div class="payment-check"></div>
          </div>
          <div class="payment-item">
            <div class="payment-icon">🏦</div>
            <span>Bank Transfer</span>
            <div class="payment-check"></div>
          </div>
        </div>

        <div class="emergency-block">
          <div class="em-label">Emergency Contact</div>
          <div class="em-number">+8801792861249</div>
        </div>
      </div><!-- end donate-left -->


      <!-- ── RIGHT FORM ── -->
      <div class="donate-right">
        <div class="donate-heading">Complete Your Donation</div>
        <div class="donate-sub">Fill in your details to proceed securely</div>

        <?php if ($show_success): ?>
          <div style="background:#e8f5ee;border:1px solid #a8d5b8;border-radius:10px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
            <i class="fas fa-check-circle" style="color:#1a7a4a;font-size:20px;"></i>
            <div>
              <strong style="color:#0f5432;">Donation submitted successfully!</strong><br>
              <span style="font-size:13px;color:#4a7a5a;">Thank you. We will contact you shortly to confirm your payment.</span>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
          <div style="background:#fff5f5;border:1px solid #f5c6cb;border-radius:10px;padding:14px 18px;margin-bottom:18px;">
            <strong style="color:#c0392b;font-size:13px;"><i class="fas fa-exclamation-circle"></i> Please fix the following:</strong>
            <ul style="margin:8px 0 0 18px;font-size:13px;color:#c0392b;">
              <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- Show a notice if project/amount came from a project page -->
        <?php if (!empty($pre_project) && !$show_success): ?>
          <div class="donate-prefill-notice">
            <i class="fas fa-circle-info"></i>
            Donating for <strong><?= htmlspecialchars($pre_project) ?></strong>
            <?php if ($pre_amount > 0): ?>
              — Amount: <strong>৳<?= number_format($pre_amount) ?></strong>
            <?php endif; ?>
            <a href="donate.php" class="prefill-clear">
              <i class="fas fa-xmark"></i> Clear
            </a>
          </div>
        <?php endif; ?>

        <form id="donateFormEl" action="donate.php" method="POST">
          <div class="form-grid">

            <!-- Select Project — pre-selected if coming from a project page -->
            <div class="form-group">
              <label>Select Project <span class="req">*</span></label>
              <select name="project" required>
                <option value="" disabled <?= empty($pre_project) ? 'selected' : '' ?>>Choose a project</option>
                <?php foreach ($all_projects as $proj): ?>
                  <option <?= ($pre_project === $proj) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($proj) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Donation Intention -->
            <div class="form-group">
              <label>Donation Intention <span class="req">*</span></label>
              <select name="intention" required>
                <option value="" disabled selected>Choose intention</option>
                <option>Sadaqah</option>
                <option>Zakat</option>
                <option>Lillah</option>
                <option>General Donation</option>
              </select>
            </div>

            <!-- Name -->
            <div class="form-group">
              <label>Your Name <span class="req">*</span></label>
              <input type="text" name="name" placeholder="Enter full name" required>
            </div>

            <!-- Mobile -->
            <div class="form-group">
              <label>Mobile Number <span class="req">*</span></label>
              <input type="tel" name="phone" placeholder="01XXXXXXXXX" required>
            </div>

            <!-- City -->
            <div class="form-group">
              <label>City <span class="req">*</span></label>
              <input type="text" name="city" placeholder="Enter your city" required>
            </div>

            <!-- Address -->
            <div class="form-group">
              <label>Address <span class="req">*</span></label>
              <input type="text" name="address" placeholder="Your full address" required>
            </div>

            <!-- Amount — pre-filled if coming from project page -->
            <div class="form-group full">
              <label>Donation Amount (BDT) <span class="req">*</span></label>
              <div class="amount-picks">
                <button type="button" class="amount-pick <?= ($pre_amount == 200)  ? 'active' : '' ?>" data-amount="200">৳ 200</button>
                <button type="button" class="amount-pick <?= ($pre_amount == 500)  ? 'active' : '' ?>" data-amount="500">৳ 500</button>
                <button type="button" class="amount-pick <?= ($pre_amount == 1000) ? 'active' : '' ?>" data-amount="1000">৳ 1,000</button>
                <button type="button" class="amount-pick <?= ($pre_amount == 2000) ? 'active' : '' ?>" data-amount="2000">৳ 2,000</button>
                <button type="button" class="amount-pick <?= ($pre_amount == 5000) ? 'active' : '' ?>" data-amount="5000">৳ 5,000</button>
              </div>
              <input
                type="number"
                name="amount"
                id="donateAmount"
                placeholder="e.g. 500"
                min="1"
                required
                value="<?= $pre_amount > 0 ? $pre_amount : '' ?>"
              >
            </div>

            <!-- CAPTCHA -->
            <div class="form-group full">
              <label>CAPTCHA <span class="req">*</span></label>
              <div class="captcha-row">
                <div class="captcha-img" id="captchaDisplay">15 + 10 = ?</div>
                <input type="text" id="captchaInput" name="captcha" class="captcha-input" placeholder="Enter answer" required>
              </div>
            </div>

            <!-- Submit -->
            <div class="form-group full">
              <button type="submit" class="btn-donate-submit">
                <i class="fas fa-shield-halved"></i> Donate Securely
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>

          </div><!-- end form-grid -->
        </form>
      </div><!-- end donate-right -->

    </div><!-- end donate-grid -->
  </div>
</div>

<?php include 'includes/footer.php'; ?>
