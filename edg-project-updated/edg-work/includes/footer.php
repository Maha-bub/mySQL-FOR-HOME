<?php
/* ============================================================
   includes/footer.php  —  Footer + JS
   ============================================================ */
/* $root was already set in header.php */
?>

<!-- ================================================================
     FOOTER
     ================================================================ -->
<footer>
  <div class="footer-inner">

    <!-- Brand -->
    <div class="footer-brand">
      <div class="logo-text">
        Esho Desh Gori
        <span>Building Bangladesh Together</span>
      </div>
      <!-- ✏️ Change description -->
      <p>A non-profit initiative dedicated to uplifting the lives of the underprivileged in Bangladesh through transparent, impactful charity work.</p>
      <div class="footer-social">
        <!-- ✏️ Replace # with your real social links -->
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        <a href="#" title="Twitter/X"><i class="fab fa-x-twitter"></i></a>
        <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="<?= $root ?>index.php">Home</a></li>
        <li><a href="<?= $root ?>about-us.php">About Us</a></li>
        <li><a href="<?= $root ?>project.php">Our Projects</a></li>
        <li><a href="<?= $root ?>gallery.php">Gallery</a></li>
        <li><a href="<?= $root ?>contact-us.php">Contact Us</a></li>
        <li><a href="<?= $root ?>donate.php">Donate</a></li>
      </ul>
    </div>

    <!-- Projects -->
    <div class="footer-col">
      <h4>Our Projects</h4>
      <ul>
        <li><a href="<?= $root ?>projects/school-bags.php">School Bags</a></li>
        <li><a href="<?= $root ?>projects/healing-bangladesh.php">Healing Bangladesh</a></li>
        <li><a href="<?= $root ?>projects/build-a-masjid.php">Build a Masjid</a></li>
        <li><a href="<?= $root ?>projects/gift-of-water.php">Gift of Water</a></li>
        <li><a href="<?= $root ?>projects/feed-daily.php">Feed Daily</a></li>
        <li><a href="<?= $root ?>projects/sponsor-yateem.php">Sponsor a Yateem</a></li>
      </ul>
    </div>

    <!-- Contact -->
    <div class="footer-col">
      <h4>Contact Us</h4>
      <ul>
        <!-- ✏️ Change contact details -->
        <li>
          <a href="mailto:letsbuildthecountry6@gmail.com">
            <i class="fas fa-envelope" style="color:#4caf73;margin-right:6px;"></i>
            letsbuildthecountry6@gmail.com
          </a>
        </li>
        <li>
          <a href="tel:+8801792861249">
            <i class="fas fa-phone" style="color:#4caf73;margin-right:6px;"></i>
            +880 1792-861249
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fas fa-location-dot" style="color:#4caf73;margin-right:6px;"></i>
            Dhaka, Bangladesh
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fas fa-clock" style="color:#4caf73;margin-right:6px;"></i>
            Sat–Thu, 9 AM – 6 PM
          </a>
        </li>
      </ul>
    </div>

  </div><!-- end footer-inner -->

  <div class="footer-bottom">
    <!-- ✏️ Change year / name -->
    <span>&copy; <?= date('Y') ?> Esho Desh Gori Foundation. All rights reserved.</span>
    <span>Designed with <i class="fas fa-heart" style="color:#4caf73;"></i> for Bangladesh</span>
  </div>
</footer>

<!-- ================================================================
     JAVASCRIPT  (loaded last for speed)
     ================================================================ -->
<script src="<?= $root ?>assets/js/script.js"></script>
</body>
</html>
