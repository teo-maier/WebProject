<?php
include '../Authentication/Config.php';
require "../Utils/FetchTableData.php";

session_start();

$cartQuery = mysqli_query($db, "select c.id, c.product_quantity, c.total_price from cart c");
$cartData = mysqli_fetch_all($cartQuery, MYSQLI_ASSOC);

$productQuery = mysqli_query($db, "select p.name, p.id as productId from cart c join products p on c.product_id=p.id");
$productData = mysqli_fetch_all($productQuery, MYSQLI_ASSOC);

$array = array_merge($cartData, $productData);

function getTotalPrice($productNameData)
{
    $totalPrice = 0;
    if ($productNameData == null) {
        return null;
    }
    foreach ($productNameData as $data) {
        if ($data['product_quantity']) {
            $totalPrice = $totalPrice + ($data['total_price'] * $data['product_quantity']);
        }
    }
    return $totalPrice;
}

$totalPrice = getTotalPrice($cartData);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/cart.css?v=<?php echo time(); ?>" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/419e925bb4.js" crossorigin="anonymous"></script>
    <title>Cart</title>
    <style>
        <?php include('../CSS/cart.css') ?>
    </style>
</head>
<body>
<?php
if (count($cartData) === 0) {
    ?>
    <h2 style="text-align: center; padding: 32px">
        Empty cart
    </h2>
    <?php
} else {
?>
<div class="cart-container">
    <div class="cart-products">
        <table class="fl-table" style="border-spacing: 16px; border-collapse: separate;">
            <thead style="line-height: 4rem">
            <tr>
                <th style="text-align: left">Product name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th style="text-align: right">Remove/Add</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="text-align: left;">
                    <?php
                    foreach ($productData as $value) {
                        ?>
                        <div>
                            <?php
                            echo $value['name'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    foreach ($cartData as $value) {
                        ?>
                        <div>
                            <?php
                            echo $value['total_price'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    foreach ($cartData as $value) {
                        ?>
                        <div>
                            <?php
                            echo $value['product_quantity'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    foreach ($productData

                             as $value):
                        ?>
                        <div class="actions-container">
                            <a href="RemoveFromCart.php?id=<?php
                            echo $value['productId'];
                            ?>" style="color: black">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </a>
                            <a href="AddToCart.php?id=<?php
                            echo $value['productId'];
                            ?>" style="color: black">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div style="align-self: flex-end">
        Total price: <?php echo $totalPrice ?>
    </div>
    <div class="button-container">
        <form action="../Orders/CreateOrder.php" style="text-decoration: none">
            <button class="btn btn-warning btn btn-block">
                Create order
            </button>
        </form>
        <?php
        }
        ?>
        <a href="../Products/GetProducts.php" title="All products" style="align-self: flex-end">
            <button class="btn btn-light">
                Go back to products
            </button>
        </a>
    </div>
</div>
</body>
</html>


