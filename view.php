<?php
include 'db.php';

$page_title = "All Products";

// ── Search & Filter ──
$search = "";
$filter = $_GET['filter'] ?? '';

if (!empty(trim($_GET['search'] ?? ''))) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
    $sql    = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%' ORDER BY id DESC";
} elseif ($filter === 'low') {
    $sql = "SELECT * FROM products WHERE quantity <= 5 ORDER BY quantity ASC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
$count  = mysqli_num_rows($result);

$msg     = $_GET['msg']  ?? '';
$msgType = $_GET['type'] ?? '';

include 'sidebar.php';
?>

<!-- HEADER -->
<div class="page-header">
  <h2><?= $filter === 'low' ? '⚠️ Low Stock Products' : 'All Products' ?></h2>
  <p>
    <?php if ($search): ?>
      <?= $count ?> result<?= $count!=1?'s':'' ?> for "<strong><?= htmlspecialchars($search) ?></strong>"
    <?php elseif ($filter === 'low'): ?>
      Products with 5 or fewer units remaining
    <?php else: ?>
      <?= $count ?> product<?= $count!=1?'s':'' ?> in your inventory
    <?php endif; ?>
  </p>
</div>

<!-- ALERT -->
<?php if ($msg): ?>
  <div class="alert alert-<?= $msgType === 'success' ? 'success' : 'error' ?>">
    <?= $msgType === 'success' ? '✅' : '❌' ?> <?= htmlspecialchars($msg) ?>
  </div>
<?php endif; ?>

<!-- TABLE CARD -->
<div class="table-card">
  <div class="table-toolbar">
    <span class="table-toolbar-title">📋 Product List</span>
    <div class="toolbar-actions">

      <!-- Search -->
      <form method="GET" style="display:flex;gap:8px;align-items:center;">
        <input type="text"
               name="search"
               class="search-input"
               placeholder="Search name or category…"
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-ghost btn-sm">🔍</button>
        <?php if ($search || $filter): ?>
          <a href="view.php" class="btn btn-ghost btn-sm">✕ Clear</a>
        <?php endif; ?>
      </form>

      <a href="insert.php" class="btn btn-primary btn-sm">➕ Add Product</a>
    </div>
  </div>

  <?php if ($count > 0): ?>
  <div style="overflow-x:auto;">
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
      <?php $i=1; while ($row = mysqli_fetch_assoc($result)): ?>
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
        <td style="max-width:180px; color:var(--muted); font-size:0.82rem;">
          <?= htmlspecialchars(substr($row['description'] ?? '', 0, 55)) ?>
          <?= strlen($row['description'] ?? '') > 55 ? '…' : '' ?>
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
  </div>

  <?php else: ?>
    <div class="empty-state">
      <div class="empty-icon"><?= $search ? '🔍' : ($filter === 'low' ? '✅' : '📭') ?></div>
      <h3>
        <?php
          if ($search)          echo "No results found";
          elseif ($filter==='low') echo "No low-stock products!";
          else                  echo "No products yet";
        ?>
      </h3>
      <p>
        <?php
          if ($search)          echo "Try a different keyword.";
          elseif ($filter==='low') echo "All products have sufficient stock.";
          else                  echo "Add your first product to the inventory.";
        ?>
      </p>
      <?php if (!$search && !$filter): ?>
        <a href="insert.php" class="btn btn-primary">➕ Add First Product</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
