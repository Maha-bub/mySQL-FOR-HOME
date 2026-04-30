<?php
// =============================================
//  sidebar.php — Shared Sidebar Navigation
//  Include this at the top of every page
// =============================================

// Figure out which page is active
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? 'Product Manager' ?></title>
  <link rel="stylesheet" href="<?= $base_path ?? '' ?>assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
</head>
<body>

<!-- MOBILE OVERLAY -->
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ══════════════ SIDEBAR ══════════════ -->
<aside class="sidebar" id="sidebar">

  <!-- Brand / Logo -->
  <div class="sidebar-brand">
    <div class="brand-icon">📦</div>
    <div class="brand-text">
      <span class="brand-name">ProductMgr</span>
      <span class="brand-tag">Inventory System</span>
    </div>
    <button class="sidebar-close" onclick="closeSidebar()">✕</button>
  </div>

  <!-- Navigation -->
  <nav class="sidebar-nav">
    <p class="nav-section-label">MAIN MENU</p>

    <a href="<?= $base_path ?? '' ?>index.php"
       class="nav-item <?= $current_page === 'index.php' ? 'active' : '' ?>">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
      </span>
      <span class="nav-label">Dashboard</span>
      <?php if ($current_page === 'index.php'): ?>
        <span class="nav-active-dot"></span>
      <?php endif; ?>
    </a>

    <a href="<?= $base_path ?? '' ?>view.php"
       class="nav-item <?= $current_page === 'view.php' ? 'active' : '' ?>">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
          <rect x="9" y="3" width="6" height="4" rx="1"/>
          <path d="M9 12h6M9 16h4"/>
        </svg>
      </span>
      <span class="nav-label">All Products</span>
      <?php if ($current_page === 'view.php'): ?>
        <span class="nav-active-dot"></span>
      <?php endif; ?>
    </a>

    <a href="<?= $base_path ?? '' ?>insert.php"
       class="nav-item <?= $current_page === 'insert.php' ? 'active' : '' ?>">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>
        </svg>
      </span>
      <span class="nav-label">Add New Product</span>
      <?php if ($current_page === 'insert.php'): ?>
        <span class="nav-active-dot"></span>
      <?php endif; ?>
    </a>

    <p class="nav-section-label" style="margin-top:20px;">MANAGE</p>

    <a href="<?= $base_path ?? '' ?>view.php?filter=low"
       class="nav-item <?= (isset($_GET['filter']) && $_GET['filter']==='low') ? 'active' : '' ?>">
      <span class="nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
          <path d="M12 9v4M12 17h.01"/>
        </svg>
      </span>
      <span class="nav-label">Low Stock</span>
    </a>

  </nav>

  <!-- Sidebar Footer -->
  <div class="sidebar-footer">
    <div class="footer-info">
      <div class="footer-avatar">PM</div>
      <div>
        <p class="footer-name">Admin User</p>
        <p class="footer-role">Store Manager</p>
      </div>
    </div>
  </div>

</aside>
<!-- ══════════════ END SIDEBAR ══════════════ -->

<!-- MAIN WRAPPER -->
<div class="main-wrapper">

  <!-- TOP BAR (mobile hamburger + page title) -->
  <header class="topbar">
    <button class="hamburger" onclick="openSidebar()" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
    <h1 class="topbar-title"><?= $page_title ?? 'Dashboard' ?></h1>
    <div class="topbar-right">
      <a href="<?= $base_path ?? '' ?>insert.php" class="topbar-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
          <path d="M12 5v14M5 12h14"/>
        </svg>
        Add Product
      </a>
    </div>
  </header>

  <!-- PAGE CONTENT STARTS HERE -->
  <main class="page-content">
