<?php
// =============================================
//  delete.php — Delete a Product
//  This file has no HTML — it just processes
//  the delete and redirects the user.
// =============================================

include 'db.php';

// 1. Check that a valid ID was passed in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view.php?msg=Invalid product ID&type=error");
    exit;
}

$id = (int) $_GET['id'];

// 2. First, get the product so we can delete its image file too
$result  = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: view.php?msg=Product not found&type=error");
    exit;
}

// 3. Delete the image file from the uploads folder (if it exists)
if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
    unlink("uploads/" . $product['image']);  // unlink = delete a file in PHP
}

// 4. Delete the product from the database
$sql = "DELETE FROM products WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    // Success! Redirect with a success message
    header("Location: view.php?msg=Product deleted successfully!&type=success");
} else {
    // Something went wrong
    header("Location: view.php?msg=Failed to delete: " . mysqli_error($conn) . "&type=error");
}

exit;
?>
