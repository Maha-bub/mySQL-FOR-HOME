<?php
$page_title = 'Contact Messages';
require_once 'includes/admin-auth.php';

if ($_POST['action'] ?? '' === 'mark_read') {
    if (!csrf_verify()) die('Invalid token.');
    $pdo->prepare('UPDATE contact_messages SET is_read=1 WHERE id=?')->execute([$_POST['id']]);
    header('Location: ' . BASE_URL . '/admin/messages.php'); exit;
}
if ($_POST['action'] ?? '' === 'delete') {
    if (!csrf_verify()) die('Invalid token.');
    $pdo->prepare('DELETE FROM contact_messages WHERE id=?')->execute([$_POST['id']]);
    flash_set('success','Message deleted.'); header('Location: ' . BASE_URL . '/admin/messages.php'); exit;
}

$filter = $_GET['filter'] ?? '';
$where  = $filter === 'unread' ? 'WHERE is_read=0' : '';
$msgs   = $pdo->query("SELECT * FROM contact_messages $where ORDER BY created_at DESC")->fetchAll();
$unread = $pdo->query('SELECT COUNT(*) FROM contact_messages WHERE is_read=0')->fetchColumn();
require_once 'includes/admin-header.php';
?>
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
  <a href="messages.php" class="btn-action <?= !$filter?'btn-edit':'' ?>" style="padding:8px 16px;">All (<?= count($msgs) ?>)</a>
  <a href="messages.php?filter=unread" class="btn-action <?= $filter==='unread'?'btn-edit':'' ?>" style="padding:8px 16px;">Unread (<?= $unread ?>)</a>
</div>
<div class="admin-table-wrap">
  <div class="table-top"><h2>Messages</h2></div>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Sender</th><th>Contact</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach($msgs as $m): ?>
    <tr style="<?= !$m['is_read']?'background:#fffbeb;':'' ?>">
      <td><?= $m['id'] ?></td>
      <td>
        <strong><?= htmlspecialchars($m['name']) ?></strong><br>
        <span style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($m['gender']) ?></span>
      </td>
      <td>
        <span style="font-size:13px;"><?= htmlspecialchars($m['email']) ?></span><br>
        <span style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($m['phone']) ?></span>
      </td>
      <td style="max-width:260px;">
        <div style="font-size:13px;color:#374151;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
          <?= htmlspecialchars(substr($m['message'],0,80)) . (strlen($m['message'])>80?'...':'') ?>
        </div>
        <div style="font-size:11px;color:#9ca3af;margin-top:2px;"><?= htmlspecialchars($m['address']) ?></div>
      </td>
      <td><span class="badge-status <?= $m['is_read']?'badge-read':'badge-unread' ?>"><?= $m['is_read']?'Read':'Unread' ?></span></td>
      <td style="font-size:12px;color:#9ca3af;"><?= date('d M Y', strtotime($m['created_at'])) ?></td>
      <td>
        <div style="display:flex;gap:6px;">
          <?php if(!$m['is_read']): ?>
          <form method="POST" style="display:inline;">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="action" value="mark_read">
            <input type="hidden" name="id" value="<?= $m['id'] ?>">
            <button type="submit" class="btn-action btn-read" title="Mark as read"><i class="fas fa-check"></i></button>
          </form>
          <?php endif; ?>
          <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this message?');">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $m['id'] ?>">
            <button type="submit" class="btn-action btn-delete"><i class="fas fa-trash"></i></button>
          </form>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if(!$msgs): ?><tr><td colspan="7" style="text-align:center;padding:32px;color:#9ca3af;">No messages found.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php require_once 'includes/admin-footer.php'; ?>
