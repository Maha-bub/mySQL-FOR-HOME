<?php
/* ============================================================
   contact-us.php  —  CONTACT PAGE
   ============================================================ */

/* ── POST Handler ── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';

    /* ── Input sanitize ── */
    $name    = trim(strip_tags($_POST['name']    ?? ''));
    $email   = trim(strip_tags($_POST['email']   ?? ''));
    $phone   = trim(strip_tags($_POST['phone']   ?? ''));
    $gender  = trim(strip_tags($_POST['gender']  ?? ''));
    $address = trim(strip_tags($_POST['address'] ?? ''));
    $message = trim(strip_tags($_POST['message'] ?? ''));
    $ip      = $_SERVER['REMOTE_ADDR'] ?? null;

    /* ── Validation ── */
    $errors = [];
    if (empty($name))                           $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                                                $errors[] = 'Valid email is required.';
    if (!preg_match('/^01[0-9]{9}$/', $phone))  $errors[] = 'Invalid phone number.';
    if (!in_array($gender, ['Male','Female','Other']))
                                                $errors[] = 'Please select a gender.';
    if (empty($address))                        $errors[] = 'Address is required.';
    if (strlen($message) < 10)                  $errors[] = 'Message is too short.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages
                (name, email, phone, gender, address, message, ip_address)
            VALUES
                (:name, :email, :phone, :gender, :address, :message, :ip)
        ");
        $stmt->execute([
            ':name'    => $name,
            ':email'   => $email,
            ':phone'   => $phone,
            ':gender'  => $gender,
            ':address' => $address,
            ':message' => $message,
            ':ip'      => $ip,
        ]);

        header('Location: contact-us.php?sent=1');
        exit;
    }
}

$page_title = "Contact Us - Esho Desh Gori";
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_donor_login();
include 'includes/header.php';

$show_sent = isset($_GET['sent']);
?>

<!-- Page Hero -->
<div class="page-hero">
  <h1>Get In <span>Touch</span></h1>
  <p>Have a question or want to collaborate? We'd love to hear from you.</p>
</div>
<div class="page-hero-rule"></div>

<div class="section-wrap" style="background:#f0faf4;">
  <div class="contact-page-wrap">

    <div class="contact-grid">

      <!-- ── LEFT INFO PANEL ── -->
      <div class="contact-left">
        <div class="contact-info-title">Let's Start a Conversation</div>
        <div class="contact-info-desc">Reach out through any channel — we respond within 24 hours.</div>

        <div class="contact-info-items">

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
            <div class="contact-info-text">
              <div class="ci-label">Phone</div>
              <!-- ✏️ Change phone number here -->
              <div class="ci-value">+8801792861249</div>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
            <div class="contact-info-text">
              <div class="ci-label">Email</div>
              <!-- ✏️ Change email here -->
              <div class="ci-value">letsbuildthecountry6@gmail.com</div>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="fas fa-location-dot"></i></div>
            <div class="contact-info-text">
              <div class="ci-label">Location</div>
              <!-- ✏️ Change address here -->
              <div class="ci-value">Dhaka, Bangladesh</div>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
            <div class="contact-info-text">
              <div class="ci-label">Office Hours</div>
              <!-- ✏️ Change hours here -->
              <div class="ci-value">Sat – Thu, 9:00 AM – 6:00 PM</div>
            </div>
          </div>

        </div><!-- end contact-info-items -->

        <!-- Social icons -->
        <div class="contact-social-row">
          <a href="#" class="contact-social-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="contact-social-btn"><i class="fab fa-instagram"></i></a>
          <a href="#" class="contact-social-btn"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="contact-social-btn"><i class="fab fa-youtube"></i></a>
        </div>

      </div><!-- end contact-left -->


      <!-- ── RIGHT FORM ── -->
      <div class="contact-right">
        <div class="form-heading">Send Us a Message</div>
        <div class="form-sub">All fields marked <span style="color:#e53e3e;">*</span> are required</div>

        <?php if ($show_sent): ?>
          <div style="background:#e8f5ee;border:1px solid #a8d5b8;border-radius:10px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
            <i class="fas fa-check-circle" style="color:#1a7a4a;font-size:20px;"></i>
            <div>
              <strong style="color:#0f5432;">Message sent successfully!</strong><br>
              <span style="font-size:13px;color:#4a7a5a;">We'll get back to you within 24 hours. Thank you!</span>
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

        <form id="contactFormEl" action="contact-us.php" method="POST">
          <div class="form-grid">

            <!-- Name -->
            <div class="form-group">
              <label>Name <span class="req">*</span></label>
              <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <!-- Email -->
            <div class="form-group">
              <label>Email <span class="req">*</span></label>
              <input type="email" name="email" placeholder="you@example.com" required>
            </div>

            <!-- Phone -->
            <div class="form-group">
              <label>Phone <span class="req">*</span></label>
              <input type="tel" name="phone" placeholder="01XXXXXXXXX" required>
            </div>

            <!-- Gender -->
            <div class="form-group">
              <label>Gender <span class="req">*</span></label>
              <div class="gender-group">
                <label class="gender-opt">
                  <input type="radio" name="gender" value="Male">
                  <div class="radio-dot"></div>
                  <span>Male</span>
                </label>
                <label class="gender-opt">
                  <input type="radio" name="gender" value="Female">
                  <div class="radio-dot"></div>
                  <span>Female</span>
                </label>
                <label class="gender-opt">
                  <input type="radio" name="gender" value="Other">
                  <div class="radio-dot"></div>
                  <span>Other</span>
                </label>
              </div>
            </div>

            <!-- Address -->
            <div class="form-group full">
              <label>Address <span class="req">*</span></label>
              <input type="text" name="address" placeholder="Your full address" required>
            </div>

            <!-- Message -->
            <div class="form-group full">
              <label>Message <span class="req">*</span></label>
              <textarea name="message" placeholder="Write your message here…" required></textarea>
            </div>

            <!-- Send button -->
            <div class="form-group full">
              <button type="submit" class="btn-send">
                <i class="fas fa-paper-plane"></i> Send Message
              </button>
            </div>

            <!-- Success toast (shown by JS after submit) -->
            <div class="success-toast" id="contactSuccessToast">
              <div class="toast-icon"><i class="fas fa-check"></i></div>
              <div class="toast-msg">
                <strong>Message sent successfully!</strong>
                <span>We'll get back to you within 24 hours. Thank you!</span>
              </div>
            </div>

          </div><!-- end form-grid -->
        </form>

      </div><!-- end contact-right -->

    </div><!-- end contact-grid -->
  </div>
</div>

<?php include 'includes/footer.php'; ?>
