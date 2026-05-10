<?php
$page_title = 'Donations';
require_once 'includes/admin-auth.php';

/* Status update */
if ($_POST['action'] ?? '' === 'update_status') {
    if (!csrf_verify()) die('Invalid token.');
    $pdo->prepare('UPDATE donations SET status=? WHERE id=?')->execute([$_POST['status'],$_POST['id']]);
    flash_set('success','Donation status updated.');
    header('Location: ' . BASE_URL . '/admin/donations.php'); exit;
}

$filter = $_GET['status'] ?? '';
$search = trim($_GET['q'] ?? '');
$where  = '1=1';
$params = [];
if ($filter) { $where .= ' AND d.status=?'; $params[] = $filter; }
if ($search) { $where .= ' AND (d.name LIKE ? OR d.phone LIKE ? OR d.project LIKE ?)'; $params = array_merge($params, ["%$search%","%$search%","%$search%"]); }

$donations = $pdo->prepare("SELECT d.*,c.title AS camp_title FROM donations d LEFT JOIN campaigns c ON d.campaign_id=c.id WHERE $where ORDER BY d.created_at DESC");
$donations->execute($params);
$donations = $donations->fetchAll();
$total_amt = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM donations WHERE status='completed'")->fetchColumn();
require_once 'includes/admin-header.php';
?>
<div style="display:flex;gap:12px;align-items:center;margin-bottom:20px;flex-wrap:wrap;">
  <form method="GET" style="display:flex;gap:8px;flex:1;flex-wrap:wrap;">
    <input type="text" name="q" class="search-input" placeholder="Search donor, phone, project..." value="<?= htmlspecialchars($search) ?>">
    <select name="status" class="search-input" onchange="this.form.submit()">
      <option value="">All Status</option>
      <option value="pending"   <?= $filter==='pending'?'selected':'' ?>>Pending</option>
      <option value="completed" <?= $filter==='completed'?'selected':'' ?>>Completed</option>
      <option value="failed"    <?= $filter==='failed'?'selected':'' ?>>Failed</option>
    </select>
    <button type="submit" class="btn-green" style="padding:8px 18px;border-radius:20px;">Filter</button>
  </form>
  <div style="background:#fff;border:1px solid #e8f0ec;border-radius:12px;padding:10px 18px;font-size:13px;">
    Total raised: <strong style="color:#1a7a4a;">৳<?= number_format($total_amt,2) ?></strong>
  </div>
</div>

<div class="admin-table-wrap">
  <div class="table-top"><h2>All Donations (<?= count($donations) ?>)</h2></div>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Donor</th><th>Campaign</th><th>Intention</th><th>Amount</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
    <?php foreach($donations as $d): ?>
    <tr>
      <td style="color:#9ca3af;"><?= $d['id'] ?></td>
      <td>
        <strong><?= htmlspecialchars($d['name']) ?></strong><br>
        <span style="color:#9ca3af;font-size:12px;"><?= htmlspecialchars($d['phone']) ?> · <?= htmlspecialchars($d['city']) ?></span>
      </td>
      <td><?= htmlspecialchars($d['camp_title'] ?? $d['project']) ?></td>
      <td><span class="badge-cat"><?= htmlspecialchars($d['intention']) ?></span></td>
      <td><strong style="color:#1a7a4a;">৳<?= number_format($d['amount'],2) ?></strong></td>
      <td><span class="badge-status badge-<?= $d['status'] ?>"><?= ucfirst($d['status']) ?></span></td>
      <td style="font-size:12px;color:#9ca3af;"><?= date('d M Y', strtotime($d['created_at'])) ?></td>
      <td>
        <form method="POST" style="display:flex;gap:6px;align-items:center;">
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="action" value="update_status">
          <input type="hidden" name="id" value="<?= $d['id'] ?>">
          <select name="status" class="search-input" style="padding:4px 8px;font-size:12px;border-radius:8px;">
            <option value="pending"   <?= $d['status']==='pending'?'selected':'' ?>>Pending</option>
            <option value="completed" <?= $d['status']==='completed'?'selected':'' ?>>Completed</option>
            <option value="failed"    <?= $d['status']==='failed'?'selected':'' ?>>Failed</option>
          </select>
          <button type="submit" class="btn-action btn-edit"><i class="fas fa-check"></i></button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if(!$donations): ?><tr><td colspan="8" style="text-align:center;padding:32px;color:#9ca3af;">No donations found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php require_once 'includes/admin-footer.php'; ?>
