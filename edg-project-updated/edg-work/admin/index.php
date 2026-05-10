<?php
$page_title = 'Dashboard';
require_once 'includes/admin-auth.php';

$total_donations  = $pdo->query('SELECT COUNT(*) FROM donations')->fetchColumn();
$total_amount     = $pdo->query('SELECT COALESCE(SUM(amount),0) FROM donations WHERE status="completed"')->fetchColumn();
$total_users      = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$total_campaigns  = $pdo->query('SELECT COUNT(*) FROM campaigns WHERE status="active"')->fetchColumn();
$unread_msgs      = $pdo->query('SELECT COUNT(*) FROM contact_messages WHERE is_read=0')->fetchColumn();

$recent_donations = $pdo->query('SELECT d.*,c.title AS campaign_title FROM donations d LEFT JOIN campaigns c ON d.campaign_id=c.id ORDER BY d.created_at DESC LIMIT 8')->fetchAll();
$top_campaigns    = $pdo->query('SELECT title,raised_amount,goal_amount,pct_funded FROM campaigns ORDER BY pct_funded DESC LIMIT 5')->fetchAll();
require_once 'includes/admin-header.php';
?>

<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background:#e8f5ee;color:#1a7a4a;"><i class="fas fa-hand-holding-dollar"></i></div>
    <div><div class="stat-label">Total Donations</div><div class="stat-value"><?= number_format($total_donations) ?></div><div class="stat-sub">all time</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fef3c7;color:#92400e;"><i class="fas fa-bangladeshi-taka-sign"></i></div>
    <div><div class="stat-label">Amount Raised</div><div class="stat-value">৳<?= number_format($total_amount) ?></div><div class="stat-sub">completed</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#e6f1fb;color:#185fa5;"><i class="fas fa-users"></i></div>
    <div><div class="stat-label">Registered Donors</div><div class="stat-value"><?= number_format($total_users) ?></div><div class="stat-sub">accounts</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#eeedfe;color:#534AB7;"><i class="fas fa-bullhorn"></i></div>
    <div><div class="stat-label">Active Campaigns</div><div class="stat-value"><?= $total_campaigns ?></div><div class="stat-sub">of 10 total</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fee2e2;color:#991b1b;"><i class="fas fa-envelope"></i></div>
    <div><div class="stat-label">Unread Messages</div><div class="stat-value"><?= $unread_msgs ?></div><div class="stat-sub"><a href="messages.php" style="color:#1a7a4a;font-size:12px;">View all →</a></div></div>
  </div>
</div>

<div class="row g-4">
  <!-- Recent Donations -->
  <div class="col-lg-7">
    <div class="admin-table-wrap">
      <div class="table-top"><h2><i class="fas fa-clock-rotate-left me-2" style="color:#1a7a4a;"></i>Recent Donations</h2><a href="donations.php" class="btn-action btn-view">View all</a></div>
      <table class="admin-table">
        <thead><tr><th>Donor</th><th>Campaign</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach($recent_donations as $d): ?>
        <tr>
          <td><strong><?= htmlspecialchars($d['name']) ?></strong><br><span style="color:#9ca3af;font-size:12px;"><?= htmlspecialchars($d['phone']) ?></span></td>
          <td><?= htmlspecialchars($d['campaign_title'] ?? $d['project']) ?></td>
          <td><strong>৳<?= number_format($d['amount'],2) ?></strong></td>
          <td><span class="badge-status badge-<?= $d['status'] ?>"><?= ucfirst($d['status']) ?></span></td>
          <td style="color:#9ca3af;font-size:12px;"><?= date('d M Y', strtotime($d['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if(!$recent_donations): ?><tr><td colspan="5" style="text-align:center;padding:24px;color:#9ca3af;">No donations yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Top Campaigns -->
  <div class="col-lg-5">
    <div class="admin-table-wrap">
      <div class="table-top"><h2><i class="fas fa-trophy me-2" style="color:#d4a017;"></i>Campaign Progress</h2></div>
      <div style="padding:8px 16px 16px;">
        <?php foreach($top_campaigns as $c): ?>
        <div style="margin-bottom:16px;">
          <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px;">
            <span style="font-weight:600;color:#111;"><?= htmlspecialchars($c['title']) ?></span>
            <span style="color:#1a7a4a;font-weight:700;"><?= $c['pct_funded'] ?>%</span>
          </div>
          <div style="background:#e8f0ec;border-radius:3px;height:6px;overflow:hidden;">
            <div style="width:<?= $c['pct_funded'] ?>%;height:100%;background:#1a7a4a;border-radius:3px;"></div>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:11px;color:#9ca3af;margin-top:3px;">
            <span>৳<?= number_format($c['raised_amount']) ?></span>
            <span>৳<?= number_format($c['goal_amount']) ?></span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
