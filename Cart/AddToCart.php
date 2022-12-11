<?php
include '../Authentication/Config.php';

$id = $_GET['id'];

$addToCartQuery = mysqli_query($db, "UPDATE cart SET product_quantity = product_quantity + 1 where cart.product_id='$id'");

if ($addToCartQuery) {
    mysqli_close($db);
    header('Location: GetCart.php');
    exit;
} else {
    echo "Error creating record";
}
?>