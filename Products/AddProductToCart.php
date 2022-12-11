<?php
include '../Authentication/Config.php';

$id = $_GET['id'];
$_SESSION['id'] = $id;
$getIdQuery = mysqli_query($db, "select id from products where id = '$id'");
//$productIdCart = mysqli_fetch_row($getIdQuery)[0];

$getProductIdFromCartQuery = mysqli_query($db, "select price from products where id = '$id'");
$productPrice = mysqli_fetch_row($getProductIdFromCartQuery)[0];

$getProductIdFromCartQuery = mysqli_query($db, "select cart.product_id from cart join products on cart.product_id=products.id where cart.product_id = '$id'");
$productIdCart = mysqli_fetch_row($getProductIdFromCartQuery)[0];

if ($productIdCart == null) {
    $addToCartQuery = mysqli_query($db, "INSERT INTO cart(product_id, product_quantity, total_price) VALUES ('$id', '1','$productPrice')");
} else {
    $addToCartQuery = mysqli_query($db, "UPDATE cart SET product_quantity = product_quantity + 1");
}
if ($addToCartQuery and $getIdQuery) {
    mysqli_close($db);
    header('Location:../Products/GetProducts.php');
    exit;
} else {
    echo "Error creating record";
}
?>

<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Get product by id</title>
</head>
<body>
<?php
echo $id_row
?>
</body>
</html>


