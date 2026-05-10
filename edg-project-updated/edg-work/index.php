<?php
/* ============================================================
   index.php  —  HOMEPAGE
   ============================================================ */
$page_title = "Esho Desh Gori - Home";
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_donor_login();
include 'includes/header.php';
?>


<!-- ============================================================
     CAROUSEL / BANNER SLIDER
     ✏️ To add a real image:  add <img src="assets/images/banner1.jpg" class="slide-bg-img" alt="">
        inside a .slide div, before .slide-content
     ============================================================ -->
<div class="carousel" id="carousel">
  <div class="carousel-track" id="carouselTrack">

    <!-- Slide 1 -->
    <div class="slide slide-1">
      <div class="slide-content">
        <div class="slide-tag">✨ Changing Lives</div>
        <h1>Help Us Build a<br><em>Better Bangladesh</em></h1>
        <p>Every donation brings hope to the underprivileged. Join thousands of donors transforming lives across the nation.</p>
        <div class="slide-actions">
          <a href="donate.php"><button class="btn-primary"><i class="fas fa-heart"></i> Donate Now</button></a>
          <a href="about-us.php"><button class="btn-outline">Learn More</button></a>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide slide-2">
      <div class="slide-content">
        <div class="slide-tag">🎒 Education Matters</div>
        <h1>Give a Child a<br><em>School Bag Today</em></h1>
        <p>Education is the most powerful weapon. Donate a school bag and change the course of a child's future.</p>
        <div class="slide-actions">
          <a href="projects/school-bags.php"><button class="btn-primary"><i class="fas fa-backpack"></i> Donate School Bags</button></a>
          <a href="project.php"><button class="btn-outline">See Projects</button></a>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="slide slide-3">
      <div class="slide-content">
        <div class="slide-tag">💧 Clean Water For All</div>
        <h1>Gift the <em>Blessing<br>of Clean Water</em></h1>
        <p>Thousands lack safe drinking water. Install a tubewell and give communities the gift of life.</p>
        <div class="slide-actions">
          <a href="projects/gift-of-water.php"><button class="btn-primary"><i class="fas fa-droplet"></i> Gift Water</button></a>
          <a href="gallery.php"><button class="btn-outline">View Impact</button></a>
        </div>
      </div>
    </div>

  </div><!-- end carousel-track -->

  <!-- Arrow buttons -->
  <button class="carousel-btn prev" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
  <button class="carousel-btn next" id="nextBtn"><i class="fas fa-chevron-right"></i></button>

  <!-- Dots -->
  <div class="carousel-dots">
    <div class="dot active" data-index="0"></div>
    <div class="dot" data-index="1"></div>
    <div class="dot" data-index="2"></div>
  </div>
</div>


<!-- ============================================================
     STATS BAR
     ✏️ Change numbers here
     ============================================================ -->
<div class="stats-bar">
  <div class="stat-item">
    <div class="stat-num">12K+</div>
    <div class="stat-label">Families Helped</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">৳2.4Cr</div>
    <div class="stat-label">Donations Raised</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">50+</div>
    <div class="stat-label">Projects Done</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">8K+</div>
    <div class="stat-label">Donors Worldwide</div>
  </div>
</div>


<!-- ============================================================
     PROJECT CARDS
     ✏️ To add a real image to a card, replace the <i class="...card-img-icon"> line
        with: <img src="assets/images/school-bags.jpg" alt="School Bags" class="card-real-img">
     ============================================================ -->
<div class="section-wrap cards-section">
  <div class="section-inner">

    <div class="section-header">
      <div class="section-label"><i class="fas fa-hand-holding-heart"></i> Our Projects</div>
      <h2 class="section-title">Choose a Cause to <span>Support</span></h2>
      <p class="section-subtitle">Every project is a step toward a stronger, kinder Bangladesh. Pick a cause and make a real difference today.</p>
    </div>

    <div class="cards-grid">

      <!-- Card 1: School Bags -->
      <div class="card">
        <div class="card-img">
          <!-- ✏️ Replace icon with: <img src="assets/images/school-bags.jpg" alt="School Bags" class="card-real-img"> -->
          <i class="fas fa-backpack card-img-icon"></i>
          <div class="card-img-label">Education</div>
        </div>
        <div class="card-body">
          <div class="card-title">School Bags</div>
          <div class="card-desc">Provide school bags filled with supplies to underprivileged children, helping them step into classrooms with confidence.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="72%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳72,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/school-bags.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 2: Income Generating -->
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
          <a href="projects/income-generating.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 3: Healing Bangladesh -->
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
          <a href="projects/healing-bangladesh.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 4: Donate a House -->
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
          <a href="projects/donate-a-house.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 5: Build a Masjid -->
      <div class="card">
        <div class="card-img purple">
          <i class="fas fa-mosque card-img-icon"></i>
          <div class="card-img-label">Faith</div>
        </div>
        <div class="card-body">
          <div class="card-title">Build a Masjid</div>
          <div class="card-desc">Contribute to constructing a Masjid in an underserved community and earn continuous blessings with every prayer offered.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="80%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳2,40,000</strong></span><span>Goal: ৳3,00,000</span></div>
          <a href="projects/build-a-masjid.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 6: Gift of Water -->
      <div class="card">
        <div class="card-img water">
          <i class="fas fa-droplet card-img-icon"></i>
          <div class="card-img-label">Water</div>
        </div>
        <div class="card-body">
          <div class="card-title">Tubewell / Gift of Water</div>
          <div class="card-desc">Install a tubewell and give clean drinking water to entire villages, reducing disease and suffering dramatically.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="90%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳45,000</strong></span><span>Goal: ৳50,000</span></div>
          <a href="projects/gift-of-water.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 7: Donate a Quran -->
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
          <a href="projects/donate-a-quran.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 8: Emergency Aid -->
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
          <a href="projects/emergency-aid.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 9: Feed Daily -->
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
          <a href="projects/feed-daily.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

      <!-- Card 10: Sponsor a Yateem -->
      <div class="card">
        <div class="card-img orphan">
          <i class="fas fa-child card-img-icon"></i>
          <div class="card-img-label">Orphan</div>
        </div>
        <div class="card-body">
          <div class="card-title">Sponsored A Yateem</div>
          <div class="card-desc">Sponsor an orphaned child's food, education, clothing and wellbeing. Be their guardian angel and earn immense reward.</div>
          <div class="progress-bar"><div class="progress-fill" data-w="60%"></div></div>
          <div class="card-meta"><span>Raised: <strong>৳60,000</strong></span><span>Goal: ৳1,00,000</span></div>
          <a href="projects/sponsor-yateem.php"><button class="btn-card"><i class="fas fa-heart"></i> Donate Now</button></a>
        </div>
      </div>

    </div><!-- end cards-grid -->
  </div>
</div>


<!-- ============================================================
     CTA BAND
     ============================================================ -->
<div class="cta-band">
  <h2>Every Taka Counts. Every Soul Matters.</h2>
  <p>Join our growing family of donors who believe in a compassionate, thriving Bangladesh.</p>
  <a href="donate.php">
    <button class="btn-primary" style="margin:0 auto;display:inline-flex;font-size:15px;padding:13px 34px;">
      <i class="fas fa-heart"></i> Donate Now
    </button>
  </a>
</div>


<!-- ============================================================
     GALLERY PREVIEW  (homepage section)
     ✏️ To add a real image:
        Replace the <div class="g-inner ..."> block with:
        <img src="assets/images/gallery/photo1.jpg" alt="Description" class="g-img">
     ============================================================ -->
<div class="gallery-section">
  <div style="max-width:1200px; margin:0 auto;">
    <div class="section-label"><i class="fas fa-images"></i> Our Work in Action</div>
    <h2 class="section-title">Gallery of <span>Impact</span></h2>
    <p class="section-subtitle">Real moments. Real lives changed. See what your donations make possible.</p>

    <div class="gallery-grid">

      <!-- Large item (spans 2 cols × 2 rows) -->
      <div class="gallery-item large">
        <!-- ✏️ Replace with: <img src="assets/images/gallery/main.jpg" alt="Community" class="g-img"> -->
        <div class="g-inner" style="background:linear-gradient(135deg,#0f5432,#23a063);">
          <i class="fas fa-hands-holding-child" style="font-size:56px;"></i>
          <span>Community Outreach</span>
        </div>
        <div class="gallery-overlay"><p>Community Outreach Program 2024</p></div>
      </div>

      <div class="gallery-item">
        <!-- ✏️ <img src="assets/images/gallery/school.jpg" alt="School" class="g-img"> -->
        <div class="g-inner" style="background:linear-gradient(135deg,#1a3a5c,#3b82c4);">
          <i class="fas fa-school"></i><span>School Bags Drive</span>
        </div>
        <div class="gallery-overlay"><p>School Bags Distribution</p></div>
      </div>

      <div class="gallery-item">
        <div class="g-inner" style="background:linear-gradient(135deg,#4a1a0a,#c06520);">
          <i class="fas fa-droplet"></i><span>Tubewell</span>
        </div>
        <div class="gallery-overlay"><p>Tubewell Installation</p></div>
      </div>

      <div class="gallery-item">
        <div class="g-inner" style="background:linear-gradient(135deg,#2d1a5c,#7c3aed);">
          <i class="fas fa-mosque"></i><span>Masjid</span>
        </div>
        <div class="gallery-overlay"><p>Masjid Construction</p></div>
      </div>

      <div class="gallery-item">
        <div class="g-inner" style="background:linear-gradient(135deg,#0a3d3a,#0d9488);">
          <i class="fas fa-bowl-food"></i><span>Feeding Program</span>
        </div>
        <div class="gallery-overlay"><p>Daily Feeding Initiative</p></div>
      </div>

      <div class="gallery-item">
        <div class="g-inner" style="background:linear-gradient(135deg,#3a1a10,#e11d48);">
          <i class="fas fa-hand-holding-heart"></i><span>Emergency Relief</span>
        </div>
        <div class="gallery-overlay"><p>Flood Emergency Aid</p></div>
      </div>

    </div><!-- end gallery-grid -->

    <div style="text-align:center; margin-top:28px;">
      <a href="gallery.php">
        <button class="btn-primary"><i class="fas fa-images"></i> View Full Gallery</button>
      </a>
    </div>
  </div>
</div>


<?php include 'includes/footer.php'; ?>
