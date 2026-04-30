<?php
include 'db.php';

$page_title = "Dashboard";

// ── Statistics ──
$total   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM products"))['c'];
$stock   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(quantity),0) c FROM products"))['c'];
$value   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(price*quantity),0) c FROM products"))['c'];
$cats    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT category) c FROM products"))['c'];
$lowstock= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM products WHERE quantity <= 5"))['c'];

// ── Recent products ──
$recent  = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 6");

include 'sidebar.php';
?>

<!-- PAGE HEADER -->
<div class="page-header">
  <h2>Dashboard</h2>
  <p>Welcome back! Here's what's happening with your inventory.</p>
</div>

<!-- STAT CARDS -->
<div class="stats-grid">

  <div class="stat-card purple">
    <div class="stat-top">
      <div class="stat-icon-box">📦</div>
      <?php if ($lowstock > 0): ?>
        <span class="stat-trend trend-down">⚠ <?= $lowstock ?> low</span>
      <?php else: ?>
        <span class="stat-trend trend-up">✓ Healthy</span>
      <?php endif; ?>
    </div>
    <div class="stat-value"><?= number_format($total) ?></div>
    <div class="stat-label">Total Products</div>
  </div>

  <div class="stat-card green">
    <div class="stat-top">
      <div class="stat-icon-box">🏷️</div>
      <span class="stat-trend trend-up">In Stock</span>
    </div>
    <div class="stat-value"><?= number_format($stock) ?></div>
    <div class="stat-label">Total Units</div>
  </div>

  <div class="stat-card yellow">
    <div class="stat-top">
      <div class="stat-icon-box">💰</div>
      <span class="stat-trend trend-up">Value</span>
    </div>
    <div class="stat-value">৳<?= number_format($value, 0) ?></div>
    <div class="stat-label">Inventory Worth</div>
  </div>

  <div class="stat-card pink">
    <div class="stat-top">
      <div class="stat-icon-box">🗂️</div>
      <span class="stat-trend trend-up">Active</span>
    </div>
    <div class="stat-value"><?= $cats ?></div>
    <div class="stat-label">Categories</div>
  </div>

</div>

<!-- RECENT PRODUCTS TABLE -->
<div class="table-card">
  <div class="table-toolbar">
    <span class="table-toolbar-title">🕐 Recently Added</span>
    <div class="toolbar-actions">
      <a href="view.php" class="btn btn-ghost btn-sm">View All Products →</a>
      <a href="insert.php" class="btn btn-primary btn-sm">➕ Add Product</a>
    </div>
  </div>

  <?php if (mysqli_num_rows($recent) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; while ($row = mysqli_fetch_assoc($recent)): ?>
      <tr>
        <td class="row-num"><?= $i++ ?></td>
        <td>
          <?php if (!empty($row['image']) && file_exists("uploads/".$row['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="product-thumb" alt="">
          <?php else: ?>
            <div class="product-placeholder">📦</div>
          <?php endif; ?>
        </td>
        <td class="product-name-cell">
          <strong><?= htmlspecialchars($row['name']) ?></strong>
          <?php if (!empty($row['description'])): ?>
            <small><?= htmlspecialchars(substr($row['description'],0,40)) ?>…</small>
          <?php endif; ?>
        </td>
        <td><span class="badge badge-purple"><?= htmlspecialchars($row['category'] ?? '—') ?></span></td>
        <td class="price-text">৳<?= number_format($row['price'],2) ?></td>
        <td>
          <?php
            $q = (int)$row['quantity'];
            if ($q === 0)    echo '<span class="badge badge-red">Out of Stock</span>';
            elseif ($q <= 5) echo '<span class="badge badge-yellow">Low: '.$q.'</span>';
            else             echo '<span class="badge badge-green">'.$q.' units</span>';
          ?>
        </td>
        <td>
          <div class="actions">
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
            <button onclick="confirmDelete(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>')"
                    class="btn btn-danger btn-sm">🗑️</button>
          </div>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <h3>No products yet</h3>
      <p>Your inventory is empty. Add your first product to get started.</p>
      <a href="insert.php" class="btn btn-primary">➕ Add First Product</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
