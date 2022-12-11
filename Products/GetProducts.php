<?php

require '../Authentication/Config.php';
require "../Utils/FetchTableData.php";

session_start();
$type = $_SESSION["type"];
//echo $_SESSION['id'];
$tableName = "Products";
$columns = ['id', 'name', 'price', 'status', 'created_at'];
$fetchData = fetch_data($db, $tableName, $columns);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/products.css?v=<?php echo time(); ?>" type="text/css">
    <script src="https://kit.fontawesome.com/419e925bb4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Products</title>
    <style>
        <?php include('../CSS/products.css') ?>
    </style>
</head>
<body>
<div class="container">
    <div class="cart-icon">
        <?php
        if ($type === 'customer') {
            ?>
            <div class="header-buttons">
                <a href="../Cart/GetCart.php">
                    <i class="fa fa-shopping-cart" aria-hidden="true" style="color: black"></i>
                </a>
                <a href="../Authentication/Login.php" title="Get products"
                   style="float: right; text-decoration: none;">
                    <button class="btn btn-light">
                        Log out
                    </button>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
    <?php echo isset($deleteMsg) ? $deleteMsg : ''; ?>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Price ($)</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Add to cart</th>
            </thead>
            <tbody>
            <?php
            if (is_array($fetchData)){
                $sn = 1;
                foreach ($fetchData

                         as $data) {
                    ?>
                    <tr>
                        <td>
                            <a href="GetProduct.php?id=<?php echo $data['id']; ?>"
                               style="text-decoration: none; color: black">
                                <?= $data['name'] ?? ''; ?>
                            </a>
                        </td>
                        <td><?php echo $data['price'] ?? ''; ?></td>
                        <td><?php echo $data['status'] ?? ''; ?></td>
                        <td><?php echo $data['created_at'] ?? ''; ?></td>
                        <td>
                            <?php
                            if ($type === 'admin') {
                                ?>
                                <div class="table-actions">
                                    <a href="EditProduct.php?id=<?php echo $data['id']; ?>">
                                        <i class="fa-solid fa-pen icon" aria-hidden="true"></i>
                                    </a>
                                    <a href="DeleteProduct.php?id=<?php echo $data['id']; ?>">
                                        <i class="fa fa-trash icon" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="table-actions">
                                    <a href="AddProductToCart.php?id=<?php echo $data['id']; ?>"
                                       style="color: black">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }else{ ?>
            <tr>
                <td colspan="8">
                    <?php echo $fetchData; ?>
                </td>
            <tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
    <?php
    if ($type === 'admin') {
        ?>
        <div class="button-container">
            <a href="../Products/CreateProduct.php" title="Create product"
               style="float: right; text-decoration: none; margin-left: 70px;">
                <button class="btn btn-light">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Create product
                </button>
            </a>
            <a href="../Index.php" title="Main page"
               style="float: right; text-decoration: none; margin-left: 70px">
                <button class="btn btn-light">
                    Main page
                </button>
            </a>
            <a href="../Authentication/Logout.php" title="Log out"
               style="float: right; text-decoration: none; margin-left: 70px">
                <button class="btn btn-light">
                    Log out
                </button>
            </a>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>