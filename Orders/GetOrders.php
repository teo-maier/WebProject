<?php
include '../Authentication/Config.php';
require "../Utils/FetchTableData.php";

$tableName = "orders";
$columns = ['id', 'user_id', 'status', 'created_at', 'total_price'];
$orderTableData = fetch_data($db, $tableName, $columns);

$orderStatus = $orderTableData[0]['status'];
$orderTotalPrice = $orderTableData[0]['total_price'];
$userId = $orderTableData[0]['user_id'];

$orderIdsQuery = "select o.id from orders o";
$getOrderIds = $db->query($orderIdsQuery);
$orderIdsData = mysqli_fetch_all($getOrderIds);

$customerEmailQuery = "select u.email from orders o join users u on o.user_id=u.id where o.user_id = '$userId' group by u.email";
$getCustomerEmail = $db->query($customerEmailQuery);
$customerEmailData = mysqli_fetch_column($getCustomerEmail);

$productQuery = "select p.product_id from products_order p join orders o on p.order_id = o.id where p.order_id = o.id";
$getProduct = $db->query($productQuery);
$productData = mysqli_fetch_all($getProduct);

function getIds($productData): array
{
    $array = array();
    for ($i = 0; $i < count($productData); $i++) {
        $productId = $productData[$i][0];
        $array[$i] = $productId;
    }
    return $array;
}

$productIds = getIds($productData);
$orderIds = getIds($orderIdsData);

function getTableInfo($db, $tableIds, $querySyntax): array
{
    $array = array();
    for ($i = 0; $i < count($tableIds); $i++) {
        $query = "$querySyntax" . "=$tableIds[$i]";
        $getQuery = $db->query($query);
        $getData = mysqli_fetch_all($getQuery);
        $getQuery = $getData[0][0];
        $array[$i] = $getQuery;
    }
    return $array;
}

$productNameArray = getTableInfo($db, $productIds, "select p.name from products_order po join products p on po.product_id=p.id where po.product_id");
$productPriceArray = getTableInfo($db, $productIds, "select p.price from products_order po join products p on po.product_id=p.id where po.product_id");

$orderStatusArray = getTableInfo($db, $orderIds, "select o.status from orders o where o.id");
$orderTotalPriceArray = getTableInfo($db, $orderIds, "select o.total_price from orders o where o.id");

$customerEmail = getTableInfo($db, $orderIds, "select u.email from orders o join users u on o.user_id=u.id where o.id");

//$array = array_merge($getProductName, $getProductPrice);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/get-orders.css?v=<?php echo time(); ?>" type="text/css">
    <script src="https://kit.fontawesome.com/419e925bb4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Orders</title>
    <style>
        <?php include('../CSS/get-orders.css') ?>
    </style>
</head>
<body>
<a href="../Index.php" title="Main page"
   style="float: right; text-decoration: none; margin-left: 70px">
    <button class="btn btn-light">
        Main page
    </button>
</a>
<div class="main-container" style="margin-top:20px">
    <div class="header-container">
        <label>
            Product's name
        </label>
        <label>
            Product's price
        </label>
        <label>
            Customer's email
        </label>
        <label>
            Order status
        </label>
        <label>
            Order total price
        </label>
        <label>
            Edit status
        </label>
        <label>
            Delete order
        </label>
    </div>
    <div class="info-container">
        <div class="product-array">
            <?php foreach ($productNameArray as $productNameValue):
                ?>
                <div><?= $productNameValue ?? ''; ?></div>
            <?php endforeach; ?>
        </div>
        <div class="product-array">
            <?php foreach ($productPriceArray as $productPriceValue):
                ?>
                <div><?= $productPriceValue ?? ''; ?></div>
            <?php endforeach; ?>
        </div>
        <div class="product-array">
            <?php foreach ($customerEmail as $value):
                ?>
                <div><?= $value ?? ''; ?></div>
            <?php endforeach; ?>
        </div>
        <div class="product-array">
            <?php foreach ($orderStatusArray as $value):
                ?>
                <div><?= $value ?? ''; ?></div>
            <?php endforeach; ?>
        </div>
        <div class="product-array">
            <?php foreach ($orderTotalPriceArray as $value):
                ?>
                <div><?= $value ?? ''; ?></div>
            <?php endforeach; ?>
        </div>
        <div style="display: flex; flex-direction: column; gap: 16px">
            <?php foreach ($orderIds as $id):
                ?>
                <div class="actions-container">
                    <div class="table-actions" style="width: 50px">
                        <a href="EditOrder.php?id=<?php echo $id ?>">
                            <i class="fa-solid fa-pen icon" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="table-actions" style="width: 50px;">
                        <a href="DeleteOrder.php?id=<?php echo $id ?>">
                            <i class="fa fa-trash icon" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
</body>
</html>
