================================================================
  ESHO DESH GORI — PROJECT GUIDE FOR BEGINNERS
  Read this before you start!
================================================================

FOLDER STRUCTURE
----------------
edg-project/
│
├── index.php              ← Homepage
├── about-us.php           ← About Us page
├── contact-us.php         ← Contact page
├── donate.php             ← Donation form page
├── project.php            ← All projects list page
├── gallery.php            ← Gallery page
│
├── assets/
│   ├── css/
│   │   └── style.css      ← ALL styles for the whole site
│   ├── js/
│   │   └── script.js      ← ALL JavaScript for the whole site
│   └── images/
│       ├── logo.png        ← ✏️ Put your logo here
│       ├── gallery/        ← ✏️ Put gallery photos here
│       │   ├── photo1.jpg
│       │   ├── photo2.jpg
│       │   └── ...
│       └── projects/       ← ✏️ Put project images here
│           ├── school-bags.jpg
│           └── ...
│
├── includes/
│   ├── header.php          ← Top bar + navbar (used on all pages)
│   └── footer.php          ← Footer + JS link (used on all pages)
│
└── projects/
    ├── _project-template.php  ← Master template (don't delete)
    ├── school-bags.php
    ├── income-generating.php
    ├── healing-bangladesh.php
    ├── donate-a-house.php
    ├── build-a-masjid.php
    ├── gift-of-water.php
    ├── donate-a-quran.php
    ├── emergency-aid.php
    ├── feed-daily.php
    └── sponsor-yateem.php


================================================================
  HOW TO CHANGE THINGS
================================================================

---- CHANGE LOGO ----
1. Open: includes/header.php
2. Find:  <img src="assets/images/logo.png" alt="EDG Logo">
3. Replace logo.png with your logo file name
4. Put your logo image in: assets/images/

---- CHANGE EMAIL / PHONE ----
1. Open: includes/header.php
2. Search for: letsbuildthecountry6@gmail.com
3. Replace with your real email

---- CHANGE SOCIAL LINKS ----
1. Open: includes/header.php
2. Find the <a href="#"> lines near "Facebook", "Instagram" etc.
3. Replace # with your real social media URLs

---- ADD A REAL IMAGE TO A GALLERY CARD ----
1. Put your image file in: assets/images/gallery/
   Example: assets/images/gallery/photo1.jpg
2. Open: gallery.php
3. Find the $photos array at the top
4. Each item looks like this:
   [
     'img'   => 'assets/images/gallery/photo1.jpg',
     'title' => 'Books Distribution — Sylhet',
     'cat'   => 'education',
     'date'  => 'March 2024',
   ],
5. Change photo1.jpg to your real image file name
6. To add more photos, copy one item and paste below it

---- ADD A REAL IMAGE TO A PROJECT CARD ----
1. Put your image in: assets/images/projects/
   Example: assets/images/projects/school-bags.jpg
2. Open: projects/school-bags.php
3. Find: $project_image = '';
4. Change to: $project_image = '../assets/images/projects/school-bags.jpg';

---- CHANGE PROJECT DESCRIPTION ----
1. Open the project file (e.g. projects/school-bags.php)
2. Edit the $description array — each line in "" is one paragraph
3. Edit $impact array — each item has "icon" and "text"
4. Change $raised, $goal, $pct for the progress bar

---- ADD AN IMAGE TO HOMEPAGE BANNER SLIDE ----
1. Put your image in: assets/images/
   Example: assets/images/banner1.jpg
2. Open: index.php
3. Find the slide div:  <div class="slide slide-1">
4. Add this line just inside it (before slide-content):
   <img src="assets/images/banner1.jpg" class="slide-bg-img" alt="">

---- CHANGE TEAM MEMBER NAMES ----
1. Open: about-us.php
2. Find: <h3>Md. Rafiqul Islam</h3>
3. Replace with real names
4. To add a photo: Replace <div class="team-img-placeholder">
   with: <img src="assets/images/team/member1.jpg" alt="Name" class="team-img">

---- ADD A NEW PROJECT PAGE ----
1. Copy: projects/school-bags.php
2. Rename it (e.g. projects/new-project.php)
3. Edit the variables at the top of the file
4. Add a card in project.php and index.php linking to it
5. Add it to the navbar dropdown in includes/header.php


================================================================
  HOW TO RUN THE PROJECT
================================================================

Option A — Using XAMPP (local):
  1. Install XAMPP: https://www.apachefriends.org/
  2. Copy this folder to: C:/xampp/htdocs/edg-project/
  3. Start Apache in XAMPP Control Panel
  4. Open browser: http://localhost/edg-project/

Option B — Using a web host:
  1. Upload all files to your hosting (via cPanel File Manager or FTP)
  2. Put files in public_html/ folder
  3. Visit your domain in the browser

================================================================
  QUICK REFERENCE: Where to find things
================================================================

Change top email/phone/social  →  includes/header.php
Change footer text             →  includes/footer.php
Change all colors              →  assets/css/style.css  (top :root block)
Add gallery photos             →  gallery.php  ($photos array)
Add project images             →  projects/[project-name].php  ($project_image)
Change JS behaviour            →  assets/js/script.js
Homepage banner slides         →  index.php  (.slide divs)
Homepage stats (12K+, ৳2.4Cr) →  index.php  (.stats-bar section)
About page text                →  about-us.php
Contact info (address etc)     →  contact-us.php  (.contact-info-items)

================================================================
