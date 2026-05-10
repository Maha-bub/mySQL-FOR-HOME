<?php
$page_title = 'Users';
require_once 'includes/admin-auth.php';

$search = trim($_GET['q'] ?? '');
if ($search) {
    $stmt = $pdo->prepare('SELECT u.*,(SELECT COUNT(*) FROM donations WHERE user_id=u.id) AS don_count,(SELECT COALESCE(SUM(amount),0) FROM donations WHERE user_id=u.id AND status="completed") AS total_donated FROM users u WHERE u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ? ORDER BY u.created_at DESC');
    $stmt->execute(["%$search%","%$search%","%$search%"]);
} else {
    $stmt = $pdo->query('SELECT u.*,(SELECT COUNT(*) FROM donations WHERE user_id=u.id) AS don_count,(SELECT COALESCE(SUM(amount),0) FROM donations WHERE user_id=u.id AND status="completed") AS total_donated FROM users u ORDER BY u.created_at DESC');
}
$users = $stmt->fetchAll();
require_once 'includes/admin-header.php';
?>
<div style="margin-bottom:20px;">
  <form method="GET" style="display:flex;gap:8px;">
    <input type="text" name="q" class="search-input" placeholder="Search by name, email, phone..." value="<?= htmlspecialchars($search) ?>" style="width:320px;">
    <button type="submit" class="btn-green" style="padding:8px 18px;border-radius:20px;">Search</button>
    <?php if($search): ?><a href="users.php" class="btn-action btn-view" style="padding:8px 14px;">Clear</a><?php endif; ?>
  </form>
</div>
<div class="admin-table-wrap">
  <div class="table-top"><h2>Registered Donors (<?= count($users) ?>)</h2></div>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Donations</th><th>Total Given</th><th>Joined</th></tr></thead>
    <tbody>
    <?php foreach($users as $u): ?>
    <tr>
      <td style="color:#9ca3af;"><?= $u['id'] ?></td>
      <td>
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:32px;height:32px;border-radius:50%;background:#e8f5ee;color:#1a7a4a;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
            <?= strtoupper(substr($u['name'],0,1)) ?>
          </div>
          <strong><?= htmlspecialchars($u['name']) ?></strong>
        </div>
      </td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= htmlspecialchars($u['phone']) ?></td>
      <td><?= htmlspecialchars($u['city'] ?: '—') ?></td>
      <td><span class="badge-cat"><?= $u['don_count'] ?> donations</span></td>
      <td style="font-weight:600;color:#1a7a4a;">৳<?= number_format($u['total_donated'],0) ?></td>
      <td style="font-size:12px;color:#9ca3af;"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(!$users): ?><tr><td colspan="8" style="text-align:center;padding:32px;color:#9ca3af;">No users found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php require_once 'includes/admin-footer.php'; ?>
