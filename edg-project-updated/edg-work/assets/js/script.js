/* ============================================================
   script.js  —  Esho Desh Gori
   Handles: mobile drawer, carousel, progress bars,
            gallery filter + lightbox, contact form,
            donate form + captcha, amount picker
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ──────────────────────────────────────────────────────────
     1. MOBILE DRAWER
     ────────────────────────────────────────────────────────── */
  var hamburger   = document.getElementById('hamburger');
  var mobileNav   = document.getElementById('mobileNav');
  var overlay     = document.getElementById('mobileOverlay');
  var mobileClose = document.getElementById('mobileClose');

  function openDrawer() {
    mobileNav.classList.add('open');
    overlay.style.display = 'block';
    requestAnimationFrame(function () { overlay.classList.add('active'); });
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    mobileNav.classList.remove('open');
    overlay.classList.remove('active');
    setTimeout(function () { overlay.style.display = 'none'; }, 300);
    document.body.style.overflow = '';
  }

  if (hamburger)   hamburger.addEventListener('click', openDrawer);
  if (mobileClose) mobileClose.addEventListener('click', closeDrawer);
  if (overlay)     overlay.addEventListener('click', closeDrawer);

  /* ──────────────────────────────────────────────────────────
     2. MOBILE PROJECTS ACCORDION
     ────────────────────────────────────────────────────────── */
  var projBtn  = document.getElementById('mobileProjectsBtn');
  var projDrop = document.getElementById('mobileDropdown');

  if (projBtn && projDrop) {
    projBtn.addEventListener('click', function () {
      var isOpen = projDrop.classList.toggle('open');
      projBtn.classList.toggle('expanded', isOpen);
    });
  }

  /* ──────────────────────────────────────────────────────────
     3. HOMEPAGE CAROUSEL
     ────────────────────────────────────────────────────────── */
  var track    = document.getElementById('carouselTrack');
  var carousel = document.getElementById('carousel');
  var dots     = document.querySelectorAll('.dot');

  if (track && dots.length) {
    var current = 0;
    var total   = dots.length;
    var timer;
    var startX  = 0;

    function goTo(idx) {
      current = (idx + total) % total;
      track.style.transform = 'translateX(-' + (current * 100) + '%)';
      dots.forEach(function (d, i) { d.classList.toggle('active', i === current); });
    }

    function resetTimer() {
      clearInterval(timer);
      timer = setInterval(function () { goTo(current + 1); }, 5000);
    }

    var prevBtn = document.getElementById('prevBtn');
    var nextBtn = document.getElementById('nextBtn');
    if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); resetTimer(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); resetTimer(); });
    dots.forEach(function (d) {
      d.addEventListener('click', function () { goTo(+d.dataset.index); resetTimer(); });
    });

    if (carousel) {
      carousel.addEventListener('touchstart', function (e) { startX = e.changedTouches[0].screenX; }, { passive: true });
      carousel.addEventListener('touchend',   function (e) {
        var diff = startX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 40) { goTo(diff > 0 ? current + 1 : current - 1); resetTimer(); }
      }, { passive: true });
    }

    resetTimer();
  }

  /* ──────────────────────────────────────────────────────────
     4. PROGRESS BAR ANIMATION
     ────────────────────────────────────────────────────────── */
  var fills = document.querySelectorAll('.progress-fill');
  if (fills.length) {
    if ('IntersectionObserver' in window) {
      var pbObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.style.width = entry.target.dataset.w || '0%';
            pbObs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.3 });
      fills.forEach(function (f) { pbObs.observe(f); });
    } else {
      fills.forEach(function (f) { f.style.width = f.dataset.w || '0%'; });
    }
  }

  /* ──────────────────────────────────────────────────────────
     5. GALLERY FILTER
     ────────────────────────────────────────────────────────── */
  var filterBar = document.getElementById('filterBar');
  if (filterBar) {
    filterBar.addEventListener('click', function (e) {
      var pill = e.target.closest('.pill');
      if (!pill) return;
      document.querySelectorAll('.pill').forEach(function (p) { p.classList.remove('active'); });
      pill.classList.add('active');
      var cat = pill.dataset.cat;
      document.querySelectorAll('.gpage-card').forEach(function (card) {
        card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
      });
      var emptyEl = document.getElementById('galleryEmpty');
      if (emptyEl) {
        var anyVisible = Array.from(document.querySelectorAll('.gpage-card'))
          .some(function (c) { return c.style.display !== 'none'; });
        emptyEl.classList.toggle('show', !anyVisible);
      }
    });
  }

  /* ──────────────────────────────────────────────────────────
     6. GALLERY LIGHTBOX
     ────────────────────────────────────────────────────────── */
  var lightbox = document.getElementById('lightbox');

  window.openLightbox = function (imgSrc, title, tag, date) {
    if (!lightbox) return;
    document.getElementById('lbImg').src              = imgSrc;
    document.getElementById('lbTitle').textContent    = title;
    document.getElementById('lbTagSmall').textContent = tag;
    document.getElementById('lbDate').textContent     = date;
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.closeLightbox = function () {
    if (!lightbox) return;
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  };

  if (lightbox) {
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) window.closeLightbox();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') window.closeLightbox();
  });

  /* ──────────────────────────────────────────────────────────
     7. GENDER RADIO BUTTONS
     ────────────────────────────────────────────────────────── */
  document.querySelectorAll('.gender-opt').forEach(function (opt) {
    opt.addEventListener('click', function () {
      document.querySelectorAll('.gender-opt').forEach(function (o) { o.classList.remove('selected'); });
      opt.classList.add('selected');
    });
  });

  /* ──────────────────────────────────────────────────────────
     8. CONTACT FORM — success toast
     ────────────────────────────────────────────────────────── */
  var contactForm = document.getElementById('contactFormEl');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var toast = document.getElementById('contactSuccessToast');
      if (toast) {
        toast.classList.add('show');
        contactForm.reset();
        document.querySelectorAll('.gender-opt').forEach(function (o) { o.classList.remove('selected'); });
        setTimeout(function () { toast.classList.remove('show'); }, 5000);
      }
    });
  }

  /* ──────────────────────────────────────────────────────────
     9. QUICK AMOUNT BUTTONS
     ────────────────────────────────────────────────────────── */
  document.querySelectorAll('.amount-pick').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.amount-pick').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var input = document.getElementById('donateAmount');
      if (input) input.value = btn.dataset.amount;
    });
  });

  var donateInput = document.getElementById('donateAmount');
  if (donateInput) {
    donateInput.addEventListener('input', function () {
      document.querySelectorAll('.amount-pick').forEach(function (b) { b.classList.remove('active'); });
    });
  }

  /* ──────────────────────────────────────────────────────────
     10. CAPTCHA
     ────────────────────────────────────────────────────────── */
  var captchaAnswer = 0;

  function generateCaptcha() {
    var a = Math.floor(Math.random() * 15) + 5;
    var b = Math.floor(Math.random() * 15) + 5;
    captchaAnswer = a + b;
    var display = document.getElementById('captchaDisplay');
    var input   = document.getElementById('captchaInput');
    if (display) display.textContent = a + ' + ' + b + ' = ?';
    if (input)   input.value = '';
  }

  if (document.getElementById('captchaDisplay')) generateCaptcha();

  var donateForm = document.getElementById('donateFormEl');
  if (donateForm) {
    donateForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var captchaInput = document.getElementById('captchaInput');
      var userAnswer   = parseInt(captchaInput ? captchaInput.value : '', 10);

      if (isNaN(userAnswer) || userAnswer !== captchaAnswer) {
        if (captchaInput) {
          captchaInput.style.borderColor = '#e53e3e';
          captchaInput.style.boxShadow   = '0 0 0 3px rgba(229,62,62,0.15)';
          setTimeout(function () {
            captchaInput.style.borderColor = '';
            captchaInput.style.boxShadow   = '';
            generateCaptcha();
          }, 1500);
        }
        return;
      }

      /* ✏️ Replace with real payment gateway:
         window.location.href = 'https://your-payment-gateway.com';  */
      alert('ধন্যবাদ! পেমেন্ট গেটওয়েতে নিয়ে যাওয়া হচ্ছে...\nThank you! Redirecting to payment gateway...');
    });
  }

}); /* end DOMContentLoaded */


/* ============================================================
   SIDEBAR DONATE WIDGET — Quick-pick buttons
   (on project pages: sidebar-pick → fills #sidebarCustomAmt)
   ============================================================ */
document.querySelectorAll('.sidebar-pick').forEach(function (btn) {
  btn.addEventListener('click', function () {
    // remove active from all sidebar picks
    document.querySelectorAll('.sidebar-pick').forEach(function (b) {
      b.classList.remove('active');
    });
    btn.classList.add('active');

    // fill the custom amount input
    var input = document.getElementById('sidebarCustomAmt');
    if (input) {
      input.value = btn.dataset.amount;
      input.focus();
    }
  });
});

/* Clear active sidebar pick when user types manually */
var sidebarAmtInput = document.getElementById('sidebarCustomAmt');
if (sidebarAmtInput) {
  sidebarAmtInput.addEventListener('input', function () {
    document.querySelectorAll('.sidebar-pick').forEach(function (b) {
      b.classList.remove('active');
    });
  });
}

/* Donate.php — mark the correct quick-pick as active on page load
   (when amount is pre-filled from GET param) */
(function () {
  var donateAmt = document.getElementById('donateAmount');
  if (!donateAmt || !donateAmt.value) return;
  var val = parseFloat(donateAmt.value);
  document.querySelectorAll('.amount-pick').forEach(function (b) {
    if (parseFloat(b.dataset.amount) === val) {
      b.classList.add('active');
    }
  });
})();
