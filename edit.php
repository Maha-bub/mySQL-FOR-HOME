<?php
include 'db.php';

$error = "";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view.php?msg=Invalid product ID&type=error");
    exit;
}

$id      = (int) $_GET['id'];
$fetch   = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($fetch);

if (!$product) {
    header("Location: view.php?msg=Product not found&type=error");
    exit;
}

$page_title = "Edit: " . htmlspecialchars($product['name']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $price       = trim($_POST['price']);
    $quantity    = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $image_name  = $product['image'];

    if (empty($name) || empty($price) || empty($quantity)) {
        $error = "Name, Price, and Quantity are required.";
    } elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a valid positive number.";
    } else {

        if (!empty($_FILES['image']['name'])) {
            $file    = $_FILES['image'];
            $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];

            if (!in_array($ext, $allowed)) {
                $error = "Only JPG, PNG, GIF, WEBP images allowed.";
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $error = "Image must be under 5MB.";
            } else {
                $new_name = time() . "_" . preg_replace('/\s+/', '_', $file['name']);
                if (move_uploaded_file($file['tmp_name'], "uploads/" . $new_name)) {
                    if (!empty($product['image']) && file_exists("uploads/" . $product['image']))
                        unlink("uploads/" . $product['image']);
                    $image_name = $new_name;
                } else {
                    $error = "Failed to upload new image.";
                }
            }
        }

        if (empty($error)) {
            $name        = mysqli_real_escape_string($conn, $name);
            $category    = mysqli_real_escape_string($conn, $category);
            $description = mysqli_real_escape_string($conn, $description);
            $price       = (float) $price;
            $quantity    = (int)   $quantity;

            $sql = "UPDATE products SET
                        name='$name', category='$category', price='$price',
                        quantity='$quantity', description='$description', image='$image_name'
                    WHERE id=$id";

            if (mysqli_query($conn, $sql)) {
                header("Location: view.php?msg=Product updated successfully!&type=success");
                exit;
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        }
    }
}

include 'sidebar.php';
?>

<div class="page-header">
  <h2>Edit Product</h2>
  <p>Updating: <strong><?= htmlspecialchars($product['name']) ?></strong></p>
</div>

<?php if ($error): ?>
  <div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-card">
  <div class="form-card-header">
    <div class="form-card-icon">✏️</div>
    <div>
      <h2>Edit Product #<?= $id ?></h2>
      <p>Make your changes then save</p>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data">
    <div class="form-body">

      <p class="form-section-label">Basic Details</p>

      <div class="form-group">
        <label>Product Name *</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <?php
          $cats = ['Electronics','Clothing','Footwear','Accessories',
                   'Kitchen','Books','Sports','Beauty','Toys','Other'];
          $cur  = $_POST['category'] ?? $product['category'];
          foreach ($cats as $c) echo "<option value='$c'" . ($cur===$c?' selected':'') . ">$c</option>";
          ?>
        </select>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Price (৳) *</label>
          <input type="number" name="price" step="0.01" min="0"
                 value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>" required>
        </div>
        <div class="form-group">
          <label>Quantity *</label>
          <input type="number" name="quantity" min="0"
                 value="<?= htmlspecialchars($_POST['quantity'] ?? $product['quantity']) ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
      </div>

      <p class="form-section-label" style="margin-top:24px;">Product Image</p>

      <!-- Current image preview -->
      <?php if (!empty($product['image']) && file_exists("uploads/".$product['image'])): ?>
        <div style="margin-bottom:16px;">
          <p style="color:var(--muted);font-size:0.82rem;margin-bottom:8px;">Current image:</p>
          <img src="uploads/<?= htmlspecialchars($product['image']) ?>"
               style="width:80px;height:80px;object-fit:cover;border-radius:12px;border:1px solid var(--border);">
        </div>
      <?php endif; ?>

      <div class="form-group">
        <div class="file-input-wrapper">
          <input type="file" id="image-upload" name="image" accept="image/*">
          <label for="image-upload" class="file-input-label">
            <span class="file-input-icon">🖼️</span>
            <span class="file-input-text">
              <strong>Click to upload new image</strong><br>
              Leave blank to keep current — JPG, PNG, GIF, WEBP
            </span>
          </label>
        </div>
        <div class="img-preview-box" id="img-preview-box" style="display:none;">
          <img id="img-preview" src="" alt="Preview">
          <div>
            <p style="color:var(--text);font-size:0.85rem;font-weight:500;">New image selected</p>
            <p style="color:var(--muted);font-size:0.78rem;">Click above to change again</p>
          </div>
        </div>
      </div>

    </div>

    <div class="form-card-footer">
      <a href="view.php" class="btn btn-outline">← Cancel</a>
      <button type="submit" class="btn btn-success">💾 Save Changes</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>
