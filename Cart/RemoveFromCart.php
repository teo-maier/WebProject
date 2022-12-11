<?php
include '../Authentication/Config.php';

$id = $_GET['id'];

$getProductQuantityFromCartQuery = mysqli_query($db, "select cart.product_quantity from cart join products on cart.product_id=products.id where cart.product_id = '$id'");
$productQuantityCart = mysqli_fetch_row($getProductQuantityFromCartQuery)[0];

function handleRemoveItem($productQuantityCart, $id, $db): bool
{
    if ($productQuantityCart > 1) {
        $addToCartQuery = mysqli_query($db, "UPDATE cart SET product_quantity = product_quantity - 1 where cart.product_id='$id'");
    } else {
        $del = mysqli_query($db, "delete from cart where product_id = '$id'"); // delete query
    }
    return true;
}


if (handleRemoveItem($productQuantityCart, $id, $db)) {
    mysqli_close($db); // Close connection
    header("location:GetCart.php"); // redirects to all records page
    exit;
} else {
    echo "Error deleting record"; // display error message if not delete
}
?>