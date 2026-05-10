<?php
/* ── Auth state for header ── */
if (!isset($_SESSION)) session_start();
if (!defined('BASE_URL')) require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$_hroot = $root ?? '';
$_hbase = BASE_URL;
$_is_donor = donor_logged_in();
$_is_guest = guest_allowed();
$_user_name = $_is_donor ? donor_name() : ($_is_guest ? 'Guest' : '');
?>
<?php
/* ============================================================
   includes/header.php  —  Top bar + Navbar
   Used on every page via:  include 'includes/header.php';
   From project pages:      include '../includes/header.php';
   ============================================================ */

/* Auto-detect if we are inside the projects/ subfolder
   so CSS/links use the correct relative path */
$in_projects = (strpos($_SERVER['PHP_SELF'], '/projects/') !== false);
$root        = $in_projects ? '../' : '';

/* Current page for active nav highlight */
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title ?? 'Esho Desh Gori') ?></title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Main stylesheet — path auto-adjusts for project sub-pages -->
  <link rel="stylesheet" href="<?= $root ?>assets/css/style.css">
</head>
<body>

<!-- ── Mobile overlay (dark bg when drawer opens) ── -->
<div class="mobile-overlay" id="mobileOverlay"></div>

<!-- ================================================================
     MOBILE DRAWER
     ================================================================ -->
<div class="mobile-nav" id="mobileNav">

  <div class="mobile-nav-header">
    <div class="logo-text">Esho Desh Gori<span>Building Bangladesh Together</span></div>
    <button class="mobile-close" id="mobileClose"><i class="fas fa-times"></i></button>
  </div>

  <div class="mobile-nav-body">
    <a href="<?= $root ?>index.php">
      <button class="mobile-nav-link <?= $current==='index.php'?'active':'' ?>">
        <i class="fas fa-home"></i> Home
      </button>
    </a>

    <!-- Projects accordion -->
    <button class="mobile-nav-link" id="mobileProjectsBtn">
      <span><i class="fas fa-hand-holding-heart"></i> Projects</span>
      <i class="fas fa-chevron-down"></i>
    </button>
    <div class="mobile-dropdown" id="mobileDropdown">
      <a href="<?= $root ?>projects/school-bags.php"><i class="fas fa-backpack"></i> School Bags</a>
      <a href="<?= $root ?>projects/income-generating.php"><i class="fas fa-seedling"></i> Income Generating</a>
      <a href="<?= $root ?>projects/healing-bangladesh.php"><i class="fas fa-heart-pulse"></i> Healing Bangladesh</a>
      <a href="<?= $root ?>projects/donate-a-house.php"><i class="fas fa-house"></i> Donate a House</a>
      <a href="<?= $root ?>projects/build-a-masjid.php"><i class="fas fa-mosque"></i> Build a Masjid</a>
      <a href="<?= $root ?>projects/gift-of-water.php"><i class="fas fa-droplet"></i> Gift of Water</a>
      <a href="<?= $root ?>projects/donate-a-quran.php"><i class="fas fa-book-open"></i> Donate a Quran</a>
      <a href="<?= $root ?>projects/emergency-aid.php"><i class="fas fa-hand-holding-heart"></i> Emergency Aid</a>
      <a href="<?= $root ?>projects/feed-daily.php"><i class="fas fa-bowl-food"></i> Feed Daily</a>
      <a href="<?= $root ?>projects/sponsor-yateem.php"><i class="fas fa-child"></i> Sponsored A Yateem</a>
    </div>

    <a href="<?= $root ?>about-us.php">
      <button class="mobile-nav-link <?= $current==='about-us.php'?'active':'' ?>">
        <i class="fas fa-info-circle"></i> About Us
      </button>
    </a>
    <a href="<?= $root ?>gallery.php">
      <button class="mobile-nav-link <?= $current==='gallery.php'?'active':'' ?>">
        <i class="fas fa-images"></i> Gallery
      </button>
    </a>
    <a href="<?= $root ?>contact-us.php">
      <button class="mobile-nav-link <?= $current==='contact-us.php'?'active':'' ?>">
        <i class="fas fa-envelope"></i> Contact Us
      </button>
    </a>
  </div>

  <div class="mobile-nav-footer">
    <a href="<?= $root ?>donate.php">
      <button class="btn-donate" style="width:100%;justify-content:center;">
        <i class="fas fa-heart"></i> Donate Now
      </button>
    </a>
  </div>

</div><!-- end mobile-nav -->


<!-- ================================================================
     TOP BAR
     ================================================================ -->
<div class="top-bar">
  <div class="contact-info">
    <!-- ✏️ Change email -->
    <a href="mailto:letsbuildthecountry6@gmail.com">
      <i class="fas fa-envelope"></i> letsbuildthecountry6@gmail.com
    </a>
    <!-- ✏️ Change phone -->
    <a href="tel:+8801792861249" class="phone-link">
      <i class="fas fa-phone"></i> +880 1792-861249
    </a>
  </div>
  <div class="social-links">
    <!-- ✏️ Replace # with real URLs -->
    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
    <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
    <a href="#" title="Twitter/X"><i class="fab fa-x-twitter"></i></a>
  </div>
</div>


<!-- ================================================================
     MAIN HEADER / NAVBAR
     ================================================================ -->
<header>
  <div class="header-inner">

    <!-- LOGO -->
    <a href="<?= $root ?>index.php" class="logo">
      <div class="logo-icon">
        <!-- ✏️ Put your logo in assets/images/logo.png -->
        <img src="<?= $root ?>assets/images/logo.png" alt="EDG Logo"
             onerror="this.style.display='none'">
      </div>
      <div class="logo-text">
        Esho Desh Gori
        <span>Building Bangladesh Together</span>
      </div>
    </a>

    <!-- DESKTOP NAV -->
    <nav id="desktopNav">

      <div class="nav-item">
        <a class="nav-link <?= $current==='index.php'?'active':'' ?>" href="<?= $root ?>index.php">Home</a>
      </div>

      <!-- Projects dropdown -->
      <div class="nav-item">
        <button class="nav-link <?= $in_projects?'active':'' ?>">
          Projects <i class="fas fa-chevron-down"></i>
        </button>
        <div class="dropdown">
          <a href="<?= $root ?>projects/school-bags.php"><i class="fas fa-backpack"></i> School Bags</a>
          <a href="<?= $root ?>projects/income-generating.php"><i class="fas fa-seedling"></i> Income Generating</a>
          <a href="<?= $root ?>projects/healing-bangladesh.php"><i class="fas fa-heart-pulse"></i> Healing Bangladesh</a>
          <a href="<?= $root ?>projects/donate-a-house.php"><i class="fas fa-house"></i> Donate a House</a>
          <a href="<?= $root ?>projects/build-a-masjid.php"><i class="fas fa-mosque"></i> Build a Masjid</a>
          <a href="<?= $root ?>projects/gift-of-water.php"><i class="fas fa-droplet"></i> Gift of Water</a>
          <a href="<?= $root ?>projects/donate-a-quran.php"><i class="fas fa-book-open"></i> Donate a Quran</a>
          <a href="<?= $root ?>projects/emergency-aid.php"><i class="fas fa-hand-holding-heart"></i> Emergency Aid</a>
          <a href="<?= $root ?>projects/feed-daily.php"><i class="fas fa-bowl-food"></i> Feed Daily</a>
          <a href="<?= $root ?>projects/sponsor-yateem.php"><i class="fas fa-child"></i> Sponsored A Yateem</a>
        </div>
      </div>

      <div class="nav-item">
        <a class="nav-link <?= $current==='about-us.php'?'active':'' ?>" href="<?= $root ?>about-us.php">About Us</a>
      </div>

      <div class="nav-item">
        <a class="nav-link <?= $current==='gallery.php'?'active':'' ?>" href="<?= $root ?>gallery.php">Gallery</a>
      </div>

      <div class="nav-item">
        <a class="nav-link <?= $current==='contact-us.php'?'active':'' ?>" href="<?= $root ?>contact-us.php">Contact Us</a>
      </div>

    </nav>

    <!-- User state pill + Donate + hamburger -->
    <div style="display:flex;align-items:center;gap:10px;">

      <?php if ($_is_donor): ?>
        <!-- Logged in donor -->
        <div style="display:flex;align-items:center;gap:8px;background:#e8f5ee;border:1px solid #b8ddc8;
                    border-radius:20px;padding:6px 14px 6px 10px;font-size:13px;color:#0f5432;">
          <i class="fas fa-user-circle" style="color:#1a7a4a;font-size:15px;"></i>
          <span style="font-weight:600;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
            <?= htmlspecialchars($_user_name) ?>
          </span>
          <a href="<?= $_hbase ?>/auth/logout.php"
             style="color:#991b1b;font-size:11px;text-decoration:none;font-weight:600;margin-left:4px;"
             title="Logout">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>

      <?php elseif ($_is_guest): ?>
        <!-- Guest browsing -->
        <div style="display:flex;align-items:center;gap:8px;background:#fef9ec;border:1px solid #f0d98a;
                    border-radius:20px;padding:6px 14px 6px 10px;font-size:13px;color:#92400e;">
          <i class="fas fa-user-secret" style="font-size:15px;"></i>
          <span style="font-weight:600;">Guest</span>
          <a href="<?= $_hbase ?>/auth/login.php"
             style="color:#1a7a4a;font-size:11px;text-decoration:none;font-weight:600;margin-left:4px;"
             title="Login">
            Login
          </a>
        </div>

      <?php endif; ?>
      <a href="<?= $root ?>donate.php" id="desktopDonate">
        <button class="btn-donate"><i class="fas fa-heart"></i> Donate Now</button>
      </a>
      <button class="hamburger" id="hamburger" aria-label="Open menu">
        <i class="fas fa-bars"></i>
      </button>
    </div><!-- end nav-right -->

  </div>
</header>
