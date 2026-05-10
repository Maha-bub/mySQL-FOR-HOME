<?php
$page_title = 'Campaigns';
require_once 'includes/admin-auth.php';

if ($_POST['action'] ?? '' === 'toggle') {
    if (!csrf_verify()) die('Invalid token.');
    $cur = $pdo->prepare('SELECT status FROM campaigns WHERE id=?'); $cur->execute([$_POST['id']]);
    $new = $cur->fetchColumn() === 'active' ? 'inactive' : 'active';
    $pdo->prepare('UPDATE campaigns SET status=? WHERE id=?')->execute([$new,$_POST['id']]);
    flash_set('success','Campaign status updated.'); header('Location: ' . BASE_URL . '/admin/campaigns.php'); exit;
}
if ($_POST['action'] ?? '' === 'delete') {
    if (!csrf_verify()) die('Invalid token.');
    $pdo->prepare('DELETE FROM campaigns WHERE id=?')->execute([$_POST['id']]);
    flash_set('success','Campaign deleted.'); header('Location: ' . BASE_URL . '/admin/campaigns.php'); exit;
}

$campaigns = $pdo->query('SELECT c.*,(SELECT COUNT(*) FROM donations WHERE campaign_id=c.id) AS donation_count FROM campaigns c ORDER BY created_at DESC')->fetchAll();
require_once 'includes/admin-header.php';
?>
<div style="margin-bottom:20px;display:flex;justify-content:flex-end;">
  <a href="campaign-edit.php" class="btn-green" style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;border-radius:30px;text-decoration:none;">
    <i class="fas fa-plus"></i> Add New Campaign
  </a>
</div>
<div class="admin-table-wrap">
  <div class="table-top"><h2>All Campaigns (<?= count($campaigns) ?>)</h2></div>
  <table class="admin-table">
    <thead><tr><th>Campaign</th><th>Category</th><th>Raised</th><th>Goal</th><th>Progress</th><th>Donations</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach($campaigns as $c): ?>
    <tr>
      <td>
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:34px;height:34px;border-radius:8px;background:<?= htmlspecialchars($c['color']) ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="<?= htmlspecialchars($c['icon']) ?>" style="color:#fff;font-size:14px;"></i>
          </div>
          <div>
            <strong><?= htmlspecialchars($c['title']) ?></strong><br>
            <span style="font-size:11px;color:#9ca3af;"><?= htmlspecialchars($c['slug']) ?></span>
          </div>
        </div>
      </td>
      <td><span class="badge-cat"><?= htmlspecialchars($c['category']) ?></span></td>
      <td style="font-weight:600;color:#1a7a4a;">৳<?= number_format($c['raised_amount'],0) ?></td>
      <td style="color:#6b7280;">৳<?= number_format($c['goal_amount'],0) ?></td>
      <td>
        <div style="display:flex;align-items:center;gap:8px;">
          <div class="mini-progress"><div class="mini-progress-fill" style="width:<?= min($c['pct_funded'],100) ?>%;"></div></div>
          <span style="font-size:12px;font-weight:600;"><?= $c['pct_funded'] ?>%</span>
        </div>
      </td>
      <td><?= $c['donation_count'] ?></td>
      <td><span class="badge-status badge-<?= $c['status'] ?>"><?= ucfirst($c['status']) ?></span></td>
      <td>
        <div style="display:flex;gap:6px;flex-wrap:wrap;">
          <a href="campaign-edit.php?id=<?= $c['id'] ?>" class="btn-action btn-edit"><i class="fas fa-pen"></i></a>
          <form method="POST" style="display:inline;">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="action" value="toggle">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button type="submit" class="btn-action btn-view" title="Toggle status"><i class="fas fa-toggle-on"></i></button>
          </form>
          <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this campaign?');">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button type="submit" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once 'includes/admin-footer.php'; ?>
