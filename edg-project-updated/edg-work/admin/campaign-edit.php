<?php
$page_title = 'Edit Campaign';
require_once 'includes/admin-auth.php';
$id = (int)($_GET['id'] ?? 0);
$campaign = $id ? $pdo->prepare('SELECT * FROM campaigns WHERE id=?') : null;
if ($campaign) { $campaign->execute([$id]); $campaign = $campaign->fetch(); }
if ($id && !$campaign) { flash_set('error','Campaign not found.'); header('Location: ' . BASE_URL . '/admin/campaigns.php'); exit; }
$page_title = $campaign ? 'Edit Campaign' : 'Add Campaign';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) die('Invalid token.');
    $slug    = trim($_POST['slug']         ?? '');
    $title   = trim($_POST['title']        ?? '');
    $cat     = trim($_POST['category']     ?? '');
    $icon    = trim($_POST['icon']         ?? '');
    $color   = trim($_POST['color']        ?? '');
    $goal    = floatval($_POST['goal_amount']   ?? 0);
    $raised  = floatval($_POST['raised_amount'] ?? 0);
    $pct     = $goal > 0 ? (int)min(100, round($raised/$goal*100)) : 0;
    $intro   = trim($_POST['intro']        ?? '');
    $status  = $_POST['status'] ?? 'active';
    if (!$slug||!$title||!$cat) $errors[] = 'Slug, title, category are required.';
    if (empty($errors)) {
        if ($campaign) {
            $pdo->prepare('UPDATE campaigns SET slug=?,title=?,category=?,icon=?,color=?,goal_amount=?,raised_amount=?,pct_funded=?,intro=?,status=? WHERE id=?')
                ->execute([$slug,$title,$cat,$icon,$color,$goal,$raised,$pct,$intro,$status,$id]);
        } else {
            $pdo->prepare('INSERT INTO campaigns (slug,title,category,icon,color,goal_amount,raised_amount,pct_funded,intro,status) VALUES (?,?,?,?,?,?,?,?,?,?)')
                ->execute([$slug,$title,$cat,$icon,$color,$goal,$raised,$pct,$intro,$status]);
        }
        flash_set('success','Campaign saved.'); header('Location: ' . BASE_URL . '/admin/campaigns.php'); exit;
    }
}
require_once 'includes/admin-header.php';
$v = fn($f) => htmlspecialchars($campaign[$f] ?? ($_POST[$f] ?? ''));
?>
<div class="form-card">
  <?php if($errors): ?>
    <div class="alert alert-danger py-2 px-3 mb-3" style="border-radius:10px;font-size:13px;">
      <?php foreach($errors as $e) echo "<div>$e</div>"; ?>
    </div>
  <?php endif; ?>
  <form method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <div class="row g-3">
      <div class="col-sm-6"><label class="form-label">Title *</label><input type="text" name="title" class="form-control" value="<?= $v('title') ?>" required></div>
      <div class="col-sm-6"><label class="form-label">Slug * <small style="color:#9ca3af;">(URL key)</small></label><input type="text" name="slug" class="form-control" value="<?= $v('slug') ?>" required></div>
      <div class="col-sm-6"><label class="form-label">Category *</label><input type="text" name="category" class="form-control" value="<?= $v('category') ?>" placeholder="Education, Health..." required></div>
      <div class="col-sm-6"><label class="form-label">FontAwesome Icon</label><input type="text" name="icon" class="form-control" value="<?= $v('icon') ?>" placeholder="fas fa-backpack"></div>
      <div class="col-sm-6"><label class="form-label">Color/Gradient CSS</label><input type="text" name="color" class="form-control" value="<?= $v('color') ?>" placeholder="linear-gradient(...)"></div>
      <div class="col-sm-6"><label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="active"   <?= ($campaign['status']??'active')==='active'?'selected':'' ?>>Active</option>
          <option value="inactive" <?= ($campaign['status']??'')==='inactive'?'selected':'' ?>>Inactive</option>
        </select>
      </div>
      <div class="col-sm-6"><label class="form-label">Goal Amount (৳)</label><input type="number" name="goal_amount" class="form-control" value="<?= $v('goal_amount') ?>" step="1000" min="0"></div>
      <div class="col-sm-6"><label class="form-label">Raised Amount (৳)</label><input type="number" name="raised_amount" class="form-control" value="<?= $v('raised_amount') ?>" step="100" min="0"></div>
      <div class="col-12"><label class="form-label">Short Introduction</label><textarea name="intro" class="form-control" rows="3" placeholder="Brief description..."><?= $v('intro') ?></textarea></div>
      <div class="col-12 mt-2" style="display:flex;gap:12px;">
        <button type="submit" class="btn-green"><i class="fas fa-save me-2"></i>Save Campaign</button>
        <a href="campaigns.php" style="background:#f3f4f6;color:#374151;border:none;border-radius:30px;padding:10px 22px;font-size:14px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;"><i class="fas fa-arrow-left"></i>Cancel</a>
      </div>
    </div>
  </form>
</div>
<?php require_once 'includes/admin-footer.php'; ?>
