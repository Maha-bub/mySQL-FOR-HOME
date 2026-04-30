<?php
// =============================================
//  delete.php — Delete a Product (no HTML)
// =============================================
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view.php?msg=Invalid product ID&type=error");
    exit;
}

$id      = (int) $_GET['id'];
$result  = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: view.php?msg=Product not found&type=error");
    exit;
}

// Delete image file
if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
    unlink("uploads/" . $product['image']);
}

// Delete from DB
if (mysqli_query($conn, "DELETE FROM products WHERE id = $id")) {
    header("Location: view.php?msg=Product deleted successfully!&type=success");
} else {
    header("Location: view.php?msg=Delete failed: " . mysqli_error($conn) . "&type=error");
}
exit;
?>
