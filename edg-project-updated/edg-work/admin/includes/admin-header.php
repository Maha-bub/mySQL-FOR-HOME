<?php
/* Admin Panel Header */
$current = basename($_SERVER['PHP_SELF']);
$base    = BASE_URL;

$nav = [
  ['file'=>'index.php',        'icon'=>'fas fa-gauge-high',        'label'=>'Dashboard'],
  ['file'=>'donations.php',    'icon'=>'fas fa-hand-holding-dollar','label'=>'Donations'],
  ['file'=>'campaigns.php',    'icon'=>'fas fa-bullhorn',           'label'=>'Campaigns'],
  ['file'=>'messages.php',     'icon'=>'fas fa-envelope',           'label'=>'Messages', 'badge'=>'unread'],
  ['file'=>'users.php',        'icon'=>'fas fa-users',              'label'=>'Users'],
];

$unread = (int)$pdo->query('SELECT COUNT(*) FROM contact_messages WHERE is_read=0')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= $page_title ?? 'Admin' ?> — EDG Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <i class="fas fa-hands-holding-heart"></i>
    <span>EDG Admin</span>
  </div>
  <nav class="sidebar-nav">
    <?php foreach($nav as $item): ?>
    <a href="<?= $base ?>/admin/<?= $item['file'] ?>" class="nav-item <?= $current===$item['file']?'active':'' ?>">
      <i class="<?= $item['icon'] ?>"></i>
      <span><?= $item['label'] ?></span>
      <?php if(($item['badge']??'')==='unread' && $unread>0): ?>
        <span class="badge-count"><?= $unread ?></span>
      <?php endif; ?>
    </a>
    <?php endforeach; ?>
  </nav>
  <div class="sidebar-footer">
    <a href="<?= $base ?>/auth/admin-logout.php" class="nav-item text-danger-soft">
      <i class="fas fa-sign-out-alt"></i><span>Logout</span>
    </a>
    <a href="<?= $base ?>/" target="_blank" class="nav-item">
      <i class="fas fa-globe"></i><span>View Site</span>
    </a>
  </div>
</aside>

<!-- Main wrap -->
<div class="main-wrap">
  <header class="topbar">
    <button class="sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('collapsed')">
      <i class="fas fa-bars"></i>
    </button>
    <h1 class="topbar-title"><?= htmlspecialchars($page_title ?? 'Dashboard') ?></h1>
    <div class="topbar-right">
      <span class="admin-badge"><i class="fas fa-user-shield me-1"></i><?= htmlspecialchars(admin_name()) ?></span>
    </div>
  </header>

  <?php $flash = flash_get(); if($flash): ?>
  <div class="alert alert-<?= $flash['type']==='success'?'success':'danger' ?> mx-4 mt-3 py-2 px-3" style="border-radius:10px;font-size:13px;">
    <?= htmlspecialchars($flash['msg']) ?>
  </div>
  <?php endif; ?>

  <main class="content">
