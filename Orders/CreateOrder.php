<?php
include '../Authentication/Config.php';
require '../Cart/GetCart.php';
include '../Utils/Util.php';

$createdAt = getTimeZone();

$currentUserId = $_SESSION['id'];

$productNameQuery = mysqli_query($db, "select c.product_quantity,c.total_price from cart c");
$productNameData = mysqli_fetch_all($productNameQuery, MYSQLI_ASSOC);

$totalPrice = getTotalPrice($productNameData);

$productIdQuery = mysqli_query($db, "select c.product_id from cart c");
$productIdData = mysqli_fetch_all($productIdQuery);

$createOrder = mysqli_query($db, "INSERT INTO orders(user_id, status, created_at, total_price)
    VALUES ('$currentUserId', 'Pending', '$createdAt', '$totalPrice' )");

if ($createOrder) {
    $lastOrderId = $db->insert_id;
    for ($i = 0; $i < count($productIdData); $i++) {
        $pId = $productIdData[$i][0];
        $createOrder = mysqli_query($db, "INSERT INTO products_order(order_id, product_id)
    VALUES ('$lastOrderId', '$pId')");
    }
    $deleteCartAfterOrderPlacedQuery = mysqli_query($db, "delete from cart");
    mysqli_close($db);
    // avoid 'http header already sent' error
    echo "<meta http-equiv='refresh' content='2; url=../Products/GetProducts.php'>";
    exit;
} else {
    echo "Error creating record";
}


