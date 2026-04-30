<?php
// =============================================
//  index.php — Dashboard / Home Page
// =============================================

include 'db.php';  // Connect to database

// ── Get statistics from database ──

// Count total products
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$total_row    = mysqli_fetch_assoc($total_result);
$total        = $total_row['total'];

// Sum all stock quantities
$stock_result = mysqli_query($conn, "SELECT SUM(quantity) as stock FROM products");
$stock_row    = mysqli_fetch_assoc($stock_result);
$stock        = $stock_row['stock'] ?? 0;

// Calculate total inventory value (price × quantity)
$value_result = mysqli_query($conn, "SELECT SUM(price * quantity) as value FROM products");
$value_row    = mysqli_fetch_assoc($value_result);
$value        = number_format($value_row['value'] ?? 0, 2);

// Count unique categories
$cat_result = mysqli_query($conn, "SELECT COUNT(DISTINCT category) as cats FROM products");
$cat_row    = mysqli_fetch_assoc($cat_result);
$cats       = $cat_row['cats'];

// Get the 5 most recently added products
$recent = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Product Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="index.php" class="brand">📦 ProductMgr <span>BETA</span></a>
  <div class="nav-links">
    <a href="index.php" class="active">🏠 Dashboard</a>
    <a href="view.php">📋 Products</a>
    <a href="insert.php">➕ Add New</a>
  </div>
</nav>

<div class="container">

  <!-- PAGE HEADER -->
  <div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome back! Here's an overview of your inventory.</p>
  </div>

  <!-- STATS CARDS -->
  <div class="stats-grid">
    <div class="stat-card purple">
      <div class="stat-icon">📦</div>
      <div class="stat-value"><?= $total ?></div>
      <div class="stat-label">Total Products</div>
    </div>
    <div class="stat-card green">
      <div class="stat-icon">🏷️</div>
      <div class="stat-value"><?= $stock ?></div>
      <div class="stat-label">Total Stock Units</div>
    </div>
    <div class="stat-card yellow">
      <div class="stat-icon">💰</div>
      <div class="stat-value">৳<?= $value ?></div>
      <div class="stat-label">Inventory Value</div>
    </div>
    <div class="stat-card pink">
      <div class="stat-icon">🗂️</div>
      <div class="stat-value"><?= $cats ?></div>
      <div class="stat-label">Categories</div>
    </div>
  </div>

  <!-- RECENT PRODUCTS TABLE -->
  <div class="table-wrapper">
    <div class="table-toolbar">
      <h2>🕐 Recently Added</h2>
      <a href="view.php" class="btn btn-outline btn-sm">View All →</a>
    </div>

    <?php if (mysqli_num_rows($recent) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Product Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($recent)): ?>
        <tr>
          <!-- Product Image -->
          <td>
            <?php if (!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="product-img" alt="">
            <?php else: ?>
              <div class="product-img-placeholder">📦</div>
            <?php endif; ?>
          </td>

          <!-- Name -->
          <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>

          <!-- Category Badge -->
          <td>
            <span class="badge badge-purple">
              <?= htmlspecialchars($row['category'] ?? 'N/A') ?>
            </span>
          </td>

          <!-- Price -->
          <td><strong>৳<?= number_format($row['price'], 2) ?></strong></td>

          <!-- Stock with color -->
          <td>
            <?php
              $qty = $row['quantity'];
              $badgeClass = $qty > 10 ? 'badge-green' : ($qty > 0 ? 'badge-yellow' : 'badge-red');
            ?>
            <span class="badge <?= $badgeClass ?>"><?= $qty ?> units</span>
          </td>

          <!-- Action Buttons -->
          <td>
            <div class="actions">
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
              <button onclick="confirmDelete(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>')"
                      class="btn btn-danger btn-sm">🗑️</button>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="empty-state">
        <div class="icon">📭</div>
        <h3>No products yet</h3>
        <p>Start by adding your first product to the inventory.</p>
        <a href="insert.php" class="btn btn-primary">➕ Add First Product</a>
      </div>
    <?php endif; ?>
  </div>

</div>

<script src="assets/js/main.js"></script>
</body>
</html>
