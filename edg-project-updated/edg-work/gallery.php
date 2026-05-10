<?php
/* ============================================================
   gallery.php  —  GALLERY PAGE
   ============================================================ */
$page_title = "Gallery - Esho Desh Gori";
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_donor_login();
include 'includes/header.php';

/* ============================================================
   ✏️ ADD YOUR GALLERY PHOTOS HERE
   Each photo is an array with:
     'img'   => path to image  (put images in assets/images/gallery/)
     'title' => caption title
     'cat'   => category key  (education | healthcare | flood | plantation | event | community)
     'date'  => date string
   ============================================================ */
$photos = [
  [
    'img'   => 'assets/images/gallery/photo1.jpg',
    'title' => 'Books Distribution — Sylhet',
    'cat'   => 'education',
    'date'  => 'March 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo2.jpg',
    'title' => 'Free Medical Camp — Rangpur',
    'cat'   => 'healthcare',
    'date'  => 'January 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo3.jpg',
    'title' => 'Tree Plantation Drive — Dhaka',
    'cat'   => 'plantation',
    'date'  => 'February 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo4.jpg',
    'title' => 'Flood Relief Operation — Sunamganj',
    'cat'   => 'flood',
    'date'  => 'June 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo5.jpg',
    'title' => 'Annual Fundraising Gala 2023',
    'cat'   => 'event',
    'date'  => 'December 2023',
  ],
  [
    'img'   => 'assets/images/gallery/photo6.jpg',
    'title' => 'Youth Volunteer Workshop',
    'cat'   => 'community',
    'date'  => 'April 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo7.jpg',
    'title' => 'Classroom Renovation — Mymensingh',
    'cat'   => 'education',
    'date'  => 'November 2023',
  ],
  [
    'img'   => 'assets/images/gallery/photo8.jpg',
    'title' => 'Mother & Child Health Initiative',
    'cat'   => 'healthcare',
    'date'  => 'March 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo9.jpg',
    'title' => 'Mangrove Planting — Sundarbans',
    'cat'   => 'plantation',
    'date'  => 'October 2023',
  ],
  [
    'img'   => 'assets/images/gallery/photo10.jpg',
    'title' => 'Eid Hamper Distribution',
    'cat'   => 'community',
    'date'  => 'April 2024',
  ],
  [
    'img'   => 'assets/images/gallery/photo11.jpg',
    'title' => 'EDG Foundation Day Celebration',
    'cat'   => 'event',
    'date'  => 'August 2023',
  ],
  [
    'img'   => 'assets/images/gallery/photo12.jpg',
    'title' => 'Water Purification Drive',
    'cat'   => 'flood',
    'date'  => 'September 2023',
  ],
  /* ✏️ Keep adding more photos in the same format above */
];

/* Category labels shown on the pills and cards */
$cat_labels = [
  'education'  => 'Education',
  'healthcare' => 'Healthcare',
  'flood'      => 'Flood Relief',
  'plantation' => 'Tree Plantation',
  'event'      => 'Events',
  'community'  => 'Community',
];
?>


<!-- ============================================================
     HERO BANNER
     ============================================================ -->
<div class="gallery-page-hero">
  <div class="eyebrow">Our Gallery</div>
  <h1>Moments That <em>Matter</em></h1>
  <p>A glimpse into the lives we're changing together.</p>
</div>


<!-- ============================================================
     FILTER + GRID
     ============================================================ -->
<div class="section-wrap" style="background:#f0faf4;">
  <div class="section-inner">

    <!-- Filter pills -->
    <div class="filter-bar" id="filterBar">
      <button class="pill active" data-cat="all">All</button>
      <?php foreach ($cat_labels as $key => $label): ?>
        <button class="pill" data-cat="<?= $key ?>"><?= $label ?></button>
      <?php endforeach; ?>
    </div>

    <!-- Photo count -->
    <p style="font-size:13px; color:#718096; margin-bottom:20px;">
      Showing <strong style="color:#2e7d4f;"><?= count($photos) ?></strong> photos
    </p>

    <!-- Gallery card grid -->
    <div class="gpage-grid">

      <?php foreach ($photos as $index => $photo): ?>
        <?php $label = $cat_labels[$photo['cat']] ?? $photo['cat']; ?>

        <!-- Each card has data-cat for JS filtering -->
        <div class="gpage-card" data-cat="<?= $photo['cat'] ?>">

          <!-- Image area — click opens lightbox -->
          <div class="gpage-card-img"
               onclick="openLightbox(
                 '<?= htmlspecialchars($photo['img']) ?>',
                 '<?= htmlspecialchars($photo['title']) ?>',
                 '<?= htmlspecialchars($label) ?>',
                 '<?= htmlspecialchars($photo['date']) ?>'
               )">

            <!-- ✏️ The <img> tag below loads your real photo automatically from the $photos array above -->
            <img
              src="<?= htmlspecialchars($photo['img']) ?>"
              alt="<?= htmlspecialchars($photo['title']) ?>"
              loading="lazy"
              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >

            <!-- Fallback if image file is missing -->
            <div class="gpage-card-img-fallback" style="display:none; width:100%; height:100%; background:linear-gradient(135deg,#1a5c2e,#4caf73); align-items:center; justify-content:center; flex-direction:column; color:rgba(255,255,255,0.5); font-size:13px; gap:8px;">
              <i class="fas fa-image" style="font-size:36px;"></i>
              <span>Image coming soon</span>
            </div>

            <!-- Hover overlay with zoom icon -->
            <div class="gpage-overlay">
              <div class="gpage-zoom"><i class="fas fa-search-plus"></i></div>
            </div>

          </div><!-- end gpage-card-img -->

          <!-- Card body text -->
          <div class="gpage-card-body">
            <span class="gpage-tag"><?= htmlspecialchars($label) ?></span>
            <div class="gpage-title"><?= htmlspecialchars($photo['title']) ?></div>
            <div class="gpage-date"><?= htmlspecialchars($photo['date']) ?></div>
          </div>

        </div><!-- end gpage-card -->

      <?php endforeach; ?>

    </div><!-- end gpage-grid -->

    <!-- Empty state (shown by JS when a filter has 0 results) -->
    <div class="gallery-empty" id="galleryEmpty">
      <i class="fas fa-image"></i>
      <p>No photos in this category yet.</p>
    </div>

  </div>
</div>


<!-- ============================================================
     LIGHTBOX  (hidden, shown when a card is clicked)
     ============================================================ -->
<div class="lightbox" id="lightbox">
  <div class="lb-box">

    <!-- Large image display -->
    <div class="lb-img-area">
      <img id="lbImg" src="" alt="Gallery Photo">
    </div>

    <!-- Footer with info + buttons -->
    <div class="lb-footer">
      <div class="lb-info">
        <div class="lb-tag-small" id="lbTagSmall"></div>
        <div class="lb-title" id="lbTitle"></div>
        <div class="lb-date"  id="lbDate"></div>
      </div>
      <div class="lb-actions">
        <button class="lb-close-btn" onclick="closeLightbox()">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>

  </div>
</div>


<?php include 'includes/footer.php'; ?>
