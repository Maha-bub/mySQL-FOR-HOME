<?php
/* ============================================================
   project.php  —  ALL PROJECTS PAGE
   ============================================================ */
$page_title = "Our Projects - Esho Desh Gori";
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_donor_login();
include 'includes/header.php';
?>

<!-- Hero -->
<div class="page-hero">
  <h1>Our <span>Projects</span></h1>
  <p>Every project is a step toward a stronger, kinder Bangladesh.</p>
</div>

<!-- Cards (same as homepage, but all on one dedicated page) -->
<div class="section-wrap cards-section">
  <div class="section-inner">

    <div class="section-header">
      <div class="section-label"><i class="fas fa-hand-holding-heart"></i> What We Do</div>
      <h2 class="section-title">Choose a Cause to <span>Support</span></h2>
      <p class="section-subtitle">Pick any project below and donate directly to the cause you care about most.</p>
    </div>

    <div class="cards-grid">

      <div class="card">
        <div class="card-img">
          <!-- ✏️ <img src="assets/images/school-bags.jpg" alt="School Bags" class="card-real-img"> -->
          <i class="fas fa-backpack card-img-icon"></i>
          <div class="card-img-label">Education</div>
        </div>
        <div class="card-body">
          <div class="card-title">School Bags</div>
          <div class="card-desc">Provide school bags filled with supplies to underprivileged children, helping them step into classrooms with confidence.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="72%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳72,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/school-bags.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img blue">
          <i class="fas fa-seedling card-img-icon"></i>
          <div class="card-img-label">Livelihood</div>
        </div>
        <div class="card-body">
          <div class="card-title">Income Generating</div>
          <div class="card-desc">Empower families with tools and training so they can build sustainable income and break the cycle of poverty.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="55%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳55,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/income-generating.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img teal">
          <i class="fas fa-heart-pulse card-img-icon"></i>
          <div class="card-img-label">Healthcare</div>
        </div>
        <div class="card-body">
          <div class="card-title">Healing Bangladesh</div>
          <div class="card-desc">Bring medical care and medicines to rural communities who have little to no access to healthcare services.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="63%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳63,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/healing-bangladesh.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img orange">
          <i class="fas fa-house card-img-icon"></i>
          <div class="card-img-label">Shelter</div>
        </div>
        <div class="card-body">
          <div class="card-title">Donate a House</div>
          <div class="card-desc">Build a safe and secure home for a homeless family, giving them shelter, dignity, and stability.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="48%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳96,000</strong></span><span>Goal: ৳2,00,000</span></div>
          <a href="projects/donate-a-house.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img purple">
          <i class="fas fa-mosque card-img-icon"></i>
          <div class="card-img-label">Faith</div>
        </div>
        <div class="card-body">
          <div class="card-title">Build a Masjid</div>
          <div class="card-desc">Contribute to constructing a Masjid in an underserved community and earn continuous blessings.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="80%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳2,40,000</strong></span><span>Goal: ৳3,00,000</span></div>
          <a href="projects/build-a-masjid.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img water">
          <i class="fas fa-droplet card-img-icon"></i>
          <div class="card-img-label">Water</div>
        </div>
        <div class="card-body">
          <div class="card-title">Tubewell / Gift of Water</div>
          <div class="card-desc">Install a tubewell and give clean drinking water to entire villages, reducing disease and suffering.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="90%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳45,000</strong></span><span>Goal: ৳50,000</span></div>
          <a href="projects/gift-of-water.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img indigo">
          <i class="fas fa-book-open card-img-icon"></i>
          <div class="card-img-label">Quran</div>
        </div>
        <div class="card-body">
          <div class="card-title">Donate a Quran</div>
          <div class="card-desc">Share the words of Allah by gifting a Quran to mosques, madrasas, and individuals who cannot afford one.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="66%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳33,000</strong></span><span>Goal: ৳50,000</span></div>
          <a href="projects/donate-a-quran.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img rose">
          <i class="fas fa-hand-holding-heart card-img-icon"></i>
          <div class="card-img-label">Emergency</div>
        </div>
        <div class="card-body">
          <div class="card-title">Emergency Aid</div>
          <div class="card-desc">Rapid relief for flood, cyclone, and disaster victims. Your donation reaches those in crisis within hours.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="85%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳85,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/emergency-aid.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img food">
          <i class="fas fa-bowl-food card-img-icon"></i>
          <div class="card-img-label">Food</div>
        </div>
        <div class="card-body">
          <div class="card-title">Feed Daily</div>
          <div class="card-desc">Ensure that hungry families receive nutritious daily meals. A small donation can feed a person for an entire week.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="77%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳77,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/feed-daily.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

      <div class="card">
        <div class="card-img orphan">
          <i class="fas fa-child card-img-icon"></i>
          <div class="card-img-label">Orphan</div>
        </div>
        <div class="card-body">
          <div class="card-title">Sponsored A Yateem</div>
          <div class="card-desc">Sponsor an orphaned child's food, education, clothing and wellbeing. Be their guardian angel.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="60%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳60,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/sponsor-yateem.php"><button class="btn-card"><i class="fas fa-arrow-right"></i> View Project</button></a>
        </div>
      </div>

    </div><!-- end cards-grid -->
  </div>
</div>

<?php include 'includes/footer.php'; ?>
