<?php
include 'db.php';

$page_title = "Add New Product";
$error      = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $price       = trim($_POST['price']);
    $quantity    = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $image_name  = "";

    if (empty($name) || empty($price) || empty($quantity)) {
        $error = "Name, Price, and Quantity are required.";
    } elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a valid positive number.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Quantity must be a valid number.";
    } else {

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $file     = $_FILES['image'];
            $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed  = ['jpg','jpeg','png','gif','webp'];

            if (!in_array($ext, $allowed)) {
                $error = "Only JPG, PNG, GIF, WEBP images allowed.";
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $error = "Image must be under 5MB.";
            } else {
                $image_name = time() . "_" . preg_replace('/\s+/', '_', $file['name']);
                if (!is_dir("uploads/")) mkdir("uploads/", 0755, true);
                if (!move_uploaded_file($file['tmp_name'], "uploads/" . $image_name)) {
                    $error      = "Image upload failed. Check folder permissions.";
                    $image_name = "";
                }
            }
        }

        if (empty($error)) {
            $name        = mysqli_real_escape_string($conn, $name);
            $category    = mysqli_real_escape_string($conn, $category);
            $description = mysqli_real_escape_string($conn, $description);
            $price       = (float) $price;
            $quantity    = (int)   $quantity;

            $sql = "INSERT INTO products (name, category, price, quantity, description, image)
                    VALUES ('$name','$category','$price','$quantity','$description','$image_name')";

            if (mysqli_query($conn, $sql)) {
                header("Location: view.php?msg=Product added successfully!&type=success");
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
  <h2>Add New Product</h2>
  <p>Fill in the form below to add a product to your inventory.</p>
</div>

<?php if ($error): ?>
  <div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="form-card">
  <div class="form-card-header">
    <div class="form-card-icon">➕</div>
    <div>
      <h2>Product Information</h2>
      <p>Fields marked * are required</p>
    </div>
  </div>

  <form method="POST" enctype="multipart/form-data">
    <div class="form-body">

      <p class="form-section-label">Basic Details</p>

      <div class="form-group">
        <label>Product Name *</label>
        <input type="text" name="name"
               placeholder="e.g. Wireless Headphones"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <?php
          $cats = ['Electronics','Clothing','Footwear','Accessories',
                   'Kitchen','Books','Sports','Beauty','Toys','Other'];
          $sel  = $_POST['category'] ?? 'Electronics';
          foreach ($cats as $c) echo "<option value='$c'" . ($sel===$c?' selected':'') . ">$c</option>";
          ?>
        </select>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Price (৳) *</label>
          <input type="number" name="price" step="0.01" min="0"
                 placeholder="0.00"
                 value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>Quantity *</label>
          <input type="number" name="quantity" min="0"
                 placeholder="0"
                 value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>" required>
        </div>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" placeholder="Describe the product (optional)…"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

      <p class="form-section-label" style="margin-top:24px;">Product Image</p>

      <div class="form-group">
        <div class="file-input-wrapper" id="upload-area">
          <input type="file" id="image-upload" name="image" accept="image/*">
          <label for="image-upload" class="file-input-label">
            <span class="file-input-icon">🖼️</span>
            <span class="file-input-text">
              <strong>Click to upload</strong> or drag & drop<br>
              JPG, PNG, GIF, WEBP — max 5MB
            </span>
          </label>
        </div>
        <!-- Preview box (hidden until image selected) -->
        <div class="img-preview-box" id="img-preview-box" style="display:none;">
          <img id="img-preview" src="" alt="Preview">
          <div>
            <p style="color:var(--text); font-size:0.85rem; font-weight:500;">Image selected</p>
            <p style="color:var(--muted); font-size:0.78rem;">Click the area above to change</p>
          </div>
        </div>
      </div>

    </div>

    <div class="form-card-footer">
      <a href="view.php" class="btn btn-outline">← Cancel</a>
      <button type="submit" class="btn btn-primary">💾 Save Product</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>
