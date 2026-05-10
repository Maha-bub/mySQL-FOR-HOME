<?php
/* ============================================================
   about-us.php  —  ABOUT US PAGE
   ============================================================ */
$page_title = "About Us - Esho Desh Gori";
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_donor_login();
include 'includes/header.php';
?>

<!-- Hero -->
<div class="about-hero">
  <h1>About <em>Esho Desh Gori</em></h1>
  <!-- ✏️ Change subtitle here -->
  <p>A movement born from love for Bangladesh — dedicated to lifting the lives of those who need it most.</p>
</div>


<!-- About Content -->
<div class="about-content">

  <!-- Image Box -->
  <div class="about-img-box">
    <!--
      ✏️ TO ADD A REAL IMAGE:
         Replace the <div class="about-placeholder"> block below with:
         <img src="assets/images/about.jpg" alt="About Us" class="about-img">
    -->
    <div class="about-placeholder">
      <i class="fas fa-hands-holding-heart"></i>
    </div>
  </div>

  <!-- Text -->
  <div class="about-text">
    <div class="section-label"><i class="fas fa-info-circle"></i> Who We Are</div>
    <!-- ✏️ Change heading here -->
    <h2>Building <span>Bangladesh</span> Together</h2>

    <!-- ✏️ Change paragraphs here -->
    <p>Esho Desh Gori (এসো দেশ গড়ি) is a non-profit charitable foundation based in Dhaka, Bangladesh. Founded with a single vision — to serve those who have the least — we have been working tirelessly across the country since 2018.</p>

    <p>From distributing school bags to orphaned children, installing tubewells in waterless villages, building homes for the homeless, and running medical camps in remote areas — our work touches every corner of society.</p>

    <p>We believe that charity is not just an act of giving, but an act of <strong>building</strong>. Every project we run, every life we change, is a brick in a stronger, kinder Bangladesh.</p>

    <!-- Values grid -->
    <div class="about-values">
      <div class="value-card">
        <i class="fas fa-eye"></i>
        <h4>Transparency</h4>
        <p>Every taka is accounted for. We publish full reports of where donations go.</p>
      </div>
      <div class="value-card">
        <i class="fas fa-heart"></i>
        <h4>Compassion</h4>
        <p>We serve without discrimination — every human life has equal worth.</p>
      </div>
      <div class="value-card">
        <i class="fas fa-bolt"></i>
        <h4>Impact</h4>
        <p>We focus on projects with real, measurable change for real families.</p>
      </div>
      <div class="value-card">
        <i class="fas fa-handshake"></i>
        <h4>Community</h4>
        <p>We partner with local communities, not just donate from a distance.</p>
      </div>
    </div>

  </div>
</div>


<!-- Stats Bar (reused from homepage) -->
<div class="stats-bar">
  <div class="stat-item"><div class="stat-num">12K+</div><div class="stat-label">Families Helped</div></div>
  <div class="stat-item"><div class="stat-num">৳2.4Cr</div><div class="stat-label">Donations Raised</div></div>
  <div class="stat-item"><div class="stat-num">50+</div><div class="stat-label">Projects Done</div></div>
  <div class="stat-item"><div class="stat-num">8K+</div><div class="stat-label">Donors Worldwide</div></div>
</div>


<!-- Team Section -->
<div class="team-section">
  <div style="max-width:1100px; margin:0 auto; text-align:center;">
    <div class="section-label" style="margin:0 auto 12px;"><i class="fas fa-users"></i> Our Team</div>
    <h2 class="section-title">The People <span>Behind the Mission</span></h2>
    <p class="section-subtitle" style="margin:0 auto;">Dedicated volunteers and professionals working every day to make a difference.</p>
  </div>

  <div class="team-grid">

    <!--
      ✏️ HOW TO ADD A TEAM MEMBER PHOTO:
         Replace <div class="team-img-placeholder"> block with:
         <img src="assets/images/team/member1.jpg" alt="Name" class="team-img">
    -->

    <div class="team-card">
      <div class="team-img-placeholder"><i class="fas fa-user"></i></div>
      <div class="team-info">
        <!-- ✏️ Change name & role here -->
        <h3>Md. Rafiqul Islam</h3>
        <span>Founder & Chairman</span>
      </div>
    </div>

    <div class="team-card">
      <div class="team-img-placeholder"><i class="fas fa-user"></i></div>
      <div class="team-info">
        <h3>Fatima Khanam</h3>
        <span>Executive Director</span>
      </div>
    </div>

    <div class="team-card">
      <div class="team-img-placeholder"><i class="fas fa-user"></i></div>
      <div class="team-info">
        <h3>Ariful Haque</h3>
        <span>Head of Projects</span>
      </div>
    </div>

    <div class="team-card">
      <div class="team-img-placeholder"><i class="fas fa-user"></i></div>
      <div class="team-info">
        <h3>Sumaiya Begum</h3>
        <span>Community Coordinator</span>
      </div>
    </div>

    <!-- ✏️ Add more team cards here in the same format -->

  </div>
</div>


<!-- CTA -->
<div class="cta-band">
  <h2>Ready to Make a Difference?</h2>
  <p>Join thousands of donors who are building Bangladesh — one act of kindness at a time.</p>
  <a href="donate.php">
    <button class="btn-primary" style="margin:0 auto;display:inline-flex;font-size:15px;padding:13px 34px;">
      <i class="fas fa-heart"></i> Donate Now
    </button>
  </a>
</div>


<?php include 'includes/footer.php'; ?>
