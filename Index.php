<?php

session_start();
include 'Authentication/Config.php';

$type = $_SESSION['type'];
$email = $_SESSION['email'];
if(!isset($_SESSION['email'])){ //if login in session is not set
    header("Location:../Authentication/Login.php");
}
if($type === 'customer') {
    header('Location:../Products/GetProducts.php');
}

$getUserIdQuery = mysqli_query($db, "SELECT id from users u where u.email = '$email'");
$userId = mysqli_fetch_row($getUserIdQuery)[0];
echo $userId;

$getUserTypeQuery = mysqli_query($db, "SELECT type from users u where u.id = '$userId' ");
$userType = mysqli_fetch_row($getUserTypeQuery)[0];

?>
<html lang="en">
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/index.css">
    <style>
        <?php include('CSS/index.css') ?>
    </style>
</head>
<body>

<?php
if ($_SESSION["email"] && $userType === 'admin') {
?>
<div class="container" style="margin-top:50px">
    <h1 style="text-align: center;"> Welcome <?php echo $_SESSION["full_name"]; ?></h1><br>
    <div class="row index-main">
        <div class="col-md-4"></div>
        <div class="col-md-4 actions">
            <a href="Products/GetProducts.php" title="Manage products">
                <button class="btn btn-warning btn btn-block">
                    Manage products
                </button>
            </a>
            <a href="Products/CreateProduct.php" title="Add products">
                <button class="btn btn-warning btn btn-block">
                    Add products
                </button>
            </a>
            <a href="Orders/GetOrders.php" title="Manage orders">
                <button class="btn btn-warning btn btn-block">
                    Manage orders
                </button>
            </a>
        </div>
        <a class='logout-button' href="Authentication/Logout.php" title="Log out" style="padding: 0 15px 0 15px; color: black;"> Logout
    </div>
    <?php
    }
    ?>
</div>

<?php
if ($_SESSION["email"] && $userType === 'customer') {
    ?>
    <div>
        <?php
        header('Location:Products/GetProducts.php')
        ?>
    </div>
    <?php
}
?>
</body>
</html>