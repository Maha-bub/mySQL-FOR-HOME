<?php
// =============================================
//  view.php — Show All Products
// =============================================

include 'db.php';

// Search functionality
$search = "";
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
    $sql    = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%' ORDER BY id DESC";
} else {
    $sql    = "SELECT * FROM products ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
$count  = mysqli_num_rows($result);

// Check for success/error messages from other pages
$msg     = $_GET['msg']  ?? '';
$msgType = $_GET['type'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Products — Product Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="brand">📦 ProductMgr <span>BETA</span></a>
  <div class="nav-links">
    <a href="index.php">🏠 Dashboard</a>
    <a href="view.php" class="active">📋 Products</a>
    <a href="insert.php">➕ Add New</a>
  </div>
</nav>

<div class="container">

  <div class="page-header">
    <h1>All Products</h1>
    <p>Showing <?= $count ?> product<?= $count != 1 ? 's' : '' ?>
       <?= $search ? "for \"$search\"" : "in inventory" ?></p>
  </div>

  <!-- ALERT MESSAGES -->
  <?php if ($msg): ?>
    <div class="alert alert-<?= $msgType == 'success' ? 'success' : 'error' ?>">
      <?= $msgType == 'success' ? '✅' : '❌' ?> <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <div class="table-wrapper">
    <!-- TOOLBAR with search + add button -->
    <div class="table-toolbar">
      <h2>📋 Product List</h2>
      <div style="display:flex; gap:10px; align-items:center;">
        <!-- Search Form -->
        <form method="GET" style="display:flex; gap:8px;">
          <input type="text"
                 name="search"
                 placeholder="Search products..."
                 value="<?= htmlspecialchars($search) ?>"
                 style="background:#0e0e12; border:1px solid #2a2a3a; border-radius:8px; padding:8px 14px; color:#e8e8f0; font-size:0.88rem; outline:none; width:200px;">
          <button type="submit" class="btn btn-outline btn-sm">🔍</button>
          <?php if ($search): ?>
            <a href="view.php" class="btn btn-outline btn-sm">✕ Clear</a>
          <?php endif; ?>
        </form>
        <a href="insert.php" class="btn btn-primary btn-sm">➕ Add Product</a>
      </div>
    </div>

    <?php if ($count > 0): ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Product Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
          <td style="color:var(--muted); font-size:0.8rem;"><?= $i++ ?></td>

          <!-- Image -->
          <td>
            <?php if (!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="product-img" alt="">
            <?php else: ?>
              <div class="product-img-placeholder">📦</div>
            <?php endif; ?>
          </td>

          <!-- Name -->
          <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>

          <!-- Category -->
          <td><span class="badge badge-purple"><?= htmlspecialchars($row['category'] ?? 'N/A') ?></span></td>

          <!-- Price -->
          <td><strong style="color:var(--green);">৳<?= number_format($row['price'], 2) ?></strong></td>

          <!-- Quantity -->
          <td>
            <?php
              $qty = $row['quantity'];
              if ($qty == 0) {
                  echo '<span class="badge badge-red">Out of Stock</span>';
              } elseif ($qty <= 5) {
                  echo '<span class="badge badge-yellow">Low: ' . $qty . '</span>';
              } else {
                  echo '<span class="badge badge-green">' . $qty . ' units</span>';
              }
            ?>
          </td>

          <!-- Description (truncated) -->
          <td style="max-width:200px; color:var(--muted); font-size:0.85rem;">
            <?= htmlspecialchars(substr($row['description'] ?? '', 0, 60)) ?>
            <?= strlen($row['description'] ?? '') > 60 ? '...' : '' ?>
          </td>

          <!-- Actions -->
          <td>
            <div class="actions">
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
              <button onclick="confirmDelete(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>')"
                      class="btn btn-danger btn-sm">🗑️ Delete</button>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <?php else: ?>
      <div class="empty-state">
        <div class="icon"><?= $search ? '🔍' : '📭' ?></div>
        <h3><?= $search ? "No results found" : "No products yet" ?></h3>
        <p><?= $search ? "Try a different search term." : "Add your first product to get started." ?></p>
        <?php if (!$search): ?>
          <a href="insert.php" class="btn btn-primary">➕ Add First Product</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
