$result = $db->query("SELECT * FROM products");

while($row = $result->fetch_assoc()){
    echo $row['product_name'];
    echo "<img src='uploads/".$row['product_image']."' width='100'>";
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW AND MODIFY PRODUCTS </title>
</head>
<body>
    <a href="edit.php?id=1">Edit</a>
<a href="delete.php?id=1">Delete</a>
</body>
</html>