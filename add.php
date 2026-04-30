include("db.php");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$image);

    $db->query("INSERT INTO products(product_name, product_price, product_image)
    VALUES('$name','$price','$image')");
}