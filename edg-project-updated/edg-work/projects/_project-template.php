<?php
/* ============================================================
   projects/_project-template.php
   ⚠️  এটা এডিট করবেন না — individual project file এডিট করুন
   ============================================================ */
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_donor_login();
include '../includes/header.php';
?>

<!-- Project pages এর shared stylesheet -->
<link rel="stylesheet" href="../assets/css/project-style.css">


<!-- ════════════════════════════════════════════════════════
     HERO / BANNER
     ════════════════════════════════════════════════════════ -->
<div class="project-hero">

  <?php if (!empty($project_hero_image)): ?>
    <img src="<?= htmlspecialchars($project_hero_image) ?>"
         alt="<?= htmlspecialchars($project_title) ?>"
         class="project-hero-bg">
  <?php endif; ?>

  <div class="project-hero-inner">
    <div class="badge"><?= htmlspecialchars($project_badge) ?></div>
    <h1><?= htmlspecialchars($project_title) ?></h1>
    <p><?= htmlspecialchars($project_intro) ?></p>
    <div class="pp-hero-btns">
      <a href="../donate.php?project=<?= urlencode($project_title) ?>" class="pp-btn-donate">
        <i class="fas fa-heart"></i> Donate Now
      </a>
      <a href="../project.php" class="pp-btn-back">
        <i class="fas fa-arrow-left"></i> All Projects
      </a>
    </div>
  </div>

</div><!-- end .project-hero -->

<div class="project-hero-rule"></div>


<!-- ════════════════════════════════════════════════════════
     BREADCRUMB
     ════════════════════════════════════════════════════════ -->
<div class="pp-breadcrumb">
  <a href="../index.php"><i class="fas fa-home" style="font-size:11px;"></i> Home</a>
  <span class="sep">›</span>
  <a href="../project.php">Projects</a>
  <span class="sep">›</span>
  <span class="current"><?= htmlspecialchars($project_title) ?></span>
</div>


<!-- ════════════════════════════════════════════════════════
     MAIN CONTENT
     ════════════════════════════════════════════════════════ -->
<div class="section-wrap">
  <div class="project-content">

    <!-- ── LEFT COLUMN ── -->
    <div>

      <!-- Project Image / Placeholder -->
      <div class="project-main-img">
        <?php if (!empty($project_image)): ?>
          <img src="<?= htmlspecialchars($project_image) ?>"
               alt="<?= htmlspecialchars($project_title) ?>"
               class="proj-img">
        <?php else: ?>
          <div class="proj-placeholder" style="background:<?= $project_color ?>;">
            <i class="<?= htmlspecialchars($project_icon) ?>"></i>
          </div>
        <?php endif; ?>
      </div>

      <!-- Description -->
      <div class="project-desc">
        <span class="pp-section-label">About This Project</span>
        <h2><?= htmlspecialchars($project_title) ?></h2>
        <?php foreach ($description as $para): ?>
          <p><?= htmlspecialchars($para) ?></p>
        <?php endforeach; ?>
      </div>

      <!-- Impact Cards -->
      <div class="impact-grid">
        <?php foreach ($impact as $item): ?>
          <div class="impact-card">
            <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
            <span><?= htmlspecialchars($item['text']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- How It Works -->
      <div class="pp-how-block" style="margin-top:20px;">
        <span class="pp-section-label">How It Works</span>
        <h2>Your Donation in 3 Steps</h2>
        <div class="how-steps">
          <div class="how-step">
            <div class="step-num">1</div>
            <div class="step-text">
              <h4>You Donate</h4>
              <p>Choose your amount and donate securely through our payment gateway.</p>
            </div>
          </div>
          <div class="how-step">
            <div class="step-num">2</div>
            <div class="step-text">
              <h4>We Deliver</h4>
              <p>Our ground team identifies beneficiaries and delivers directly to them.</p>
            </div>
          </div>
          <div class="how-step">
            <div class="step-num">3</div>
            <div class="step-text">
              <h4>You See the Impact</h4>
              <p>We share photos and updates so you can see exactly how your donation helped.</p>
            </div>
          </div>
        </div>
      </div>

    </div><!-- end left column -->


    <!-- ── RIGHT SIDEBAR ── -->
    <div class="donate-sidebar">

      <h3>Support This Project</h3>

      <!-- Progress -->
      <div class="sidebar-meta">
        <span>Raised: <strong><?= htmlspecialchars($raised) ?></strong></span>
        <span>Goal: <?= htmlspecialchars($goal) ?></span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" data-w="<?= htmlspecialchars($pct) ?>%"></div>
      </div>
      <span class="sidebar-pct"><?= htmlspecialchars($pct) ?>% funded</span>

      <!-- ══════════════════════════════════════════════════
           QUICK DONATE WIDGET
           User amount pick + custom input → donate.php
           ══════════════════════════════════════════════════ -->
      <form
        id="sidebarDonateForm"
        action="../donate.php"
        method="GET"
        style="margin-top:16px;"
      >
        <!-- Hidden: project name pre-selected on donate.php -->
        <input type="hidden" name="project" value="<?= htmlspecialchars($project_title) ?>">

        <span class="sidebar-label">Choose an Amount:</span>

        <!-- Quick-pick buttons — click sets the hidden input -->
        <div class="amount-picks" style="margin-bottom:10px;">
          <button type="button" class="amount-pick sidebar-pick" data-amount="200">৳ 200</button>
          <button type="button" class="amount-pick sidebar-pick" data-amount="500">৳ 500</button>
          <button type="button" class="amount-pick sidebar-pick" data-amount="1000">৳ 1,000</button>
          <button type="button" class="amount-pick sidebar-pick" data-amount="2000">৳ 2,000</button>
        </div>

        <!-- Custom amount input -->
        <div class="sidebar-custom-amount">
          <label for="sidebarCustomAmt" style="font-size:12px;font-weight:600;color:#4a5568;margin-bottom:5px;display:block;">
            Or enter custom amount (BDT):
          </label>
          <div class="sidebar-amount-row">
            <span class="taka-sign">৳</span>
            <input
              type="number"
              id="sidebarCustomAmt"
              name="amount"
              min="1"
              placeholder="e.g. 1500"
              class="sidebar-amount-input"
              required
            >
          </div>
        </div>

        <!-- Donate Now button submits the form -->
        <button type="submit" class="pp-sidebar-donate" style="margin-top:14px;">
          <i class="fas fa-heart"></i> Donate Now
        </button>

      </form><!-- end #sidebarDonateForm -->

      <hr>

      <!-- Project identity -->
      <div class="pp-project-id">
        <div class="pp-id-icon" style="background:<?= $project_color ?>;">
          <i class="<?= htmlspecialchars($project_icon) ?>"></i>
        </div>
        <div>
          <div class="pp-id-name"><?= htmlspecialchars($project_title) ?></div>
          <div class="pp-id-cat"><?= htmlspecialchars($project_badge) ?> Project</div>
        </div>
      </div>

      <!-- Trust points -->
      <ul class="pp-trust-list">
        <li><i class="fas fa-shield-halved"></i> 100% secure payment</li>
        <li><i class="fas fa-check-circle"></i> Verified charity</li>
        <li><i class="fas fa-camera"></i> Photo updates for donors</li>
      </ul>

      <!-- Help -->
      <div class="sidebar-help">
        <div class="help-label">Need Help?</div>
        <div class="help-number">+8801792861249</div>
      </div>

    </div><!-- end .donate-sidebar -->

  </div><!-- end .project-content -->
</div>


<!-- Related Projects -->
<div class="related-strip">
  <div class="section-inner">
    <h3>Explore Other Projects</h3>
    <p class="pp-strip-sub">Every cause matters — find the one closest to your heart.</p>
    <div class="related-grid">

      <a href="school-bags.php" class="related-card">
        <div class="related-icon" style="background:linear-gradient(135deg,#1a3a5c,#3b82c4);"><i class="fas fa-backpack"></i></div>
        <div class="related-info"><div class="r-title">School Bags</div><div class="r-sub">Education</div></div>
      </a>
      <a href="healing-bangladesh.php" class="related-card">
        <div class="related-icon" style="background:linear-gradient(135deg,#0a3d3a,#0d9488);"><i class="fas fa-heart-pulse"></i></div>
        <div class="related-info"><div class="r-title">Healing Bangladesh</div><div class="r-sub">Healthcare</div></div>
      </a>
      <a href="gift-of-water.php" class="related-card">
        <div class="related-icon" style="background:linear-gradient(135deg,#0c3d4a,#0891b2);"><i class="fas fa-droplet"></i></div>
        <div class="related-info"><div class="r-title">Gift of Water</div><div class="r-sub">Water</div></div>
      </a>
      <a href="emergency-aid.php" class="related-card">
        <div class="related-icon" style="background:linear-gradient(135deg,#4a0a1a,#e11d48);"><i class="fas fa-hand-holding-heart"></i></div>
        <div class="related-info"><div class="r-title">Emergency Aid</div><div class="r-sub">Emergency</div></div>
      </a>
      <a href="feed-daily.php" class="related-card">
        <div class="related-icon" style="background:linear-gradient(135deg,#1a3a10,#4a8c20);"><i class="fas fa-bowl-food"></i></div>
        <div class="related-info"><div class="r-title">Feed Daily</div><div class="r-sub">Food</div></div>
      </a>
      <a href="sponsor-yateem.php" class="related-card">
        <div class="related-icon" style="background:linear-gradient(135deg,#3a1a10,#c05020);"><i class="fas fa-child"></i></div>
        <div class="related-info"><div class="r-title">Sponsor a Yateem</div><div class="r-sub">Orphan</div></div>
      </a>

    </div>
  </div>
</div>


<?php include '../includes/footer.php'; ?>
