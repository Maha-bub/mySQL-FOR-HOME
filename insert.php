<?php
// =============================================
//  insert.php — Add New Product
// =============================================

include 'db.php';

$error   = "";
$success = "";

// This block runs when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Get form values and clean them
    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $price       = trim($_POST['price']);
    $quantity    = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $image_name  = "";

    // 2. Basic validation
    if (empty($name) || empty($price) || empty($quantity)) {
        $error = "Name, Price, and Quantity are required fields.";
    }
    elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a valid positive number.";
    }
    elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Quantity must be a valid positive number.";
    }
    else {
        // 3. Handle image upload (if a file was selected)
        if (!empty($_FILES['image']['name'])) {
            $file      = $_FILES['image'];
            $file_name = $file['name'];
            $file_tmp  = $file['tmp_name'];
            $file_size = $file['size'];
            $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Only allow these image types
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($file_ext, $allowed_types)) {
                $error = "Only JPG, PNG, GIF, WEBP images are allowed.";
            }
            elseif ($file_size > 5 * 1024 * 1024) {  // 5MB limit
                $error = "Image must be smaller than 5MB.";
            }
            else {
                // Create a unique filename so images don't overwrite each other
                $image_name = time() . "_" . preg_replace('/\s+/', '_', $file_name);
                $upload_dir = "uploads/";

                // Create uploads folder if it doesn't exist
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Move file from temp location to uploads folder
                if (!move_uploaded_file($file_tmp, $upload_dir . $image_name)) {
                    $error      = "Failed to upload image. Check folder permissions.";
                    $image_name = "";
                }
            }
        }

        // 4. If no errors, save to database
        if (empty($error)) {
            // Sanitize values to prevent SQL injection
            $name        = mysqli_real_escape_string($conn, $name);
            $category    = mysqli_real_escape_string($conn, $category);
            $description = mysqli_real_escape_string($conn, $description);
            $price       = (float) $price;
            $quantity    = (int)   $quantity;

            // Build and run the INSERT query
            $sql = "INSERT INTO products (name, category, price, quantity, description, image)
                    VALUES ('$name', '$category', '$price', '$quantity', '$description', '$image_name')";

            if (mysqli_query($conn, $sql)) {
                // Redirect to view page with success message
                header("Location: view.php?msg=Product added successfully!&type=success");
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
  <title>Add Product — Product Manager</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="brand">📦 ProductMgr <span>BETA</span></a>
  <div class="nav-links">
    <a href="index.php">🏠 Dashboard</a>
    <a href="view.php">📋 Products</a>
    <a href="insert.php" class="active">➕ Add New</a>
  </div>
</nav>

<div class="container">

  <div class="page-header">
    <h1>Add New Product</h1>
    <p>Fill in the details below to add a product to your inventory.</p>
  </div>

  <!-- Show error if any -->
  <?php if ($error): ?>
    <div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <!-- THE FORM -->
  <div class="form-card">
    <div class="form-header">
      <h2>➕ Product Information</h2>
      <p>Fields marked with * are required</p>
    </div>

    <form method="POST" enctype="multipart/form-data" class="form-body">

      <!-- Product Name -->
      <div class="form-group">
        <label>Product Name *</label>
        <input type="text"
               name="name"
               placeholder="e.g. Wireless Headphones"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
               required>
      </div>

      <!-- Category -->
      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <?php
          $categories = ['Electronics', 'Clothing', 'Footwear', 'Accessories',
                         'Kitchen', 'Books', 'Sports', 'Beauty', 'Toys', 'Other'];
          $selected_cat = $_POST['category'] ?? '';
          foreach ($categories as $cat) {
              $sel = ($selected_cat === $cat) ? 'selected' : '';
              echo "<option value='$cat' $sel>$cat</option>";
          }
          ?>
        </select>
      </div>

      <!-- Price & Quantity side by side -->
      <div class="form-row">
        <div class="form-group">
          <label>Price (৳) *</label>
          <input type="number"
                 name="price"
                 placeholder="0.00"
                 step="0.01"
                 min="0"
                 value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"
                 required>
        </div>
        <div class="form-group">
          <label>Quantity *</label>
          <input type="number"
                 name="quantity"
                 placeholder="0"
                 min="0"
                 value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>"
                 required>
        </div>
      </div>

      <!-- Description -->
      <div class="form-group">
        <label>Description</label>
        <textarea name="description"
                  placeholder="Optional: describe the product..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

      <!-- Image Upload -->
      <div class="form-group">
        <label>Product Image (JPG/PNG, max 5MB)</label>
        <input type="file" name="image" id="image" accept="image/*">
      </div>

    </form>

    <div class="form-footer">
      <a href="view.php" class="btn btn-outline">← Cancel</a>
      <!-- Submit button outside <form> won't work, so we use JS trick -->
      <button class="btn btn-primary"
              onclick="this.closest('.form-card').querySelector('form').submit()">
        💾 Save Product
      </button>
    </div>
  </div>

</div>

<script src="assets/js/main.js"></script>
</body>
</html>
