<?php
// =============================================
//  edit.php — Update Existing Product
// =============================================

include 'db.php';

$error   = "";
$success = "";

// 1. Get the product ID from URL (e.g. edit.php?id=5)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view.php?msg=Invalid product ID&type=error");
    exit;
}

$id = (int) $_GET['id'];

// 2. Load the product from database
$fetch  = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($fetch);

if (!$product) {
    header("Location: view.php?msg=Product not found&type=error");
    exit;
}

// 3. Handle form submission (when user clicks Save)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $price       = trim($_POST['price']);
    $quantity    = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $image_name  = $product['image'];  // Keep old image by default

    // Validation
    if (empty($name) || empty($price) || empty($quantity)) {
        $error = "Name, Price, and Quantity are required fields.";
    }
    elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a valid positive number.";
    }
    else {
        // Handle new image upload (if user chose a new image)
        if (!empty($_FILES['image']['name'])) {
            $file      = $_FILES['image'];
            $file_tmp  = $file['tmp_name'];
            $file_size = $file['size'];
            $file_ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($file_ext, $allowed_types)) {
                $error = "Only JPG, PNG, GIF, WEBP images allowed.";
            }
            elseif ($file_size > 5 * 1024 * 1024) {
                $error = "Image must be smaller than 5MB.";
            }
            else {
                $new_name = time() . "_" . preg_replace('/\s+/', '_', $file['name']);
                if (move_uploaded_file($file_tmp, "uploads/" . $new_name)) {
                    // Delete old image file to save space
                    if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
                        unlink("uploads/" . $product['image']);
                    }
                    $image_name = $new_name;
                } else {
                    $error = "Failed to upload new image.";
                }
            }
        }

        // Save to database if no errors
        if (empty($error)) {
            $name        = mysqli_real_escape_string($conn, $name);
            $category    = mysqli_real_escape_string($conn, $category);
            $description = mysqli_real_escape_string($conn, $description);
            $price       = (float) $price;
            $quantity    = (int)   $quantity;

            $sql = "UPDATE products SET
                        name        = '$name',
                        category    = '$category',
                        price       = '$price',
                        quantity    = '$quantity',
                        description = '$description',
                        image       = '$image_name'
                    WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                header("Location: view.php?msg=Product updated successfully!&type=success");
                exit;
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product — Product Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="brand">📦 ProductMgr <span>BETA</span></a>
  <div class="nav-links">
    <a href="index.php">🏠 Dashboard</a>
    <a href="view.php">📋 Products</a>
    <a href="insert.php">➕ Add New</a>
  </div>
</nav>

<div class="container">

  <div class="page-header">
    <h1>Edit Product</h1>
    <p>Update the details for: <strong><?= htmlspecialchars($product['name']) ?></strong></p>
  </div>

  <?php if ($error): ?>
    <div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <div class="form-card">
    <div class="form-header">
      <h2>✏️ Edit Product #<?= $id ?></h2>
      <p>Make your changes and click Save.</p>
    </div>

    <form method="POST" enctype="multipart/form-data" class="form-body">

      <div class="form-group">
        <label>Product Name *</label>
        <input type="text"
               name="name"
               value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>"
               required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <?php
          $categories  = ['Electronics','Clothing','Footwear','Accessories',
                          'Kitchen','Books','Sports','Beauty','Toys','Other'];
          $current_cat = $_POST['category'] ?? $product['category'];
          foreach ($categories as $cat) {
              $sel = ($current_cat === $cat) ? 'selected' : '';
              echo "<option value='$cat' $sel>$cat</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Price (৳) *</label>
          <input type="number"
                 name="price"
                 step="0.01"
                 min="0"
                 value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>"
                 required>
        </div>
        <div class="form-group">
          <label>Quantity *</label>
          <input type="number"
                 name="quantity"
                 min="0"
                 value="<?= htmlspecialchars($_POST['quantity'] ?? $product['quantity']) ?>"
                 required>
        </div>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
      </div>

      <!-- Show current image if exists -->
      <div class="form-group">
        <label>Product Image</label>
        <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
          <div style="margin-bottom: 10px;">
            <p style="color:var(--muted); font-size:0.83rem; margin-bottom:6px;">Current image:</p>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>"
                 style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:1px solid var(--border);">
          </div>
        <?php endif; ?>
        <input type="file" name="image" id="image" accept="image/*">
        <p style="color:var(--muted); font-size:0.8rem; margin-top:6px;">
          Leave empty to keep the current image.
        </p>
      </div>

    </form>

    <div class="form-footer">
      <a href="view.php" class="btn btn-outline">← Cancel</a>
      <button class="btn btn-success"
              onclick="this.closest('.form-card').querySelector('form').submit()">
        💾 Save Changes
      </button>
    </div>
  </div>

</div>

<script src="assets/js/main.js"></script>
</body>
</html>
