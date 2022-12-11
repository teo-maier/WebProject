<?php
include '../Authentication/Config.php';
require "../Utils/FetchTableData.php";

$id = $_GET['id'];

$getProductByIdQuery = "select * from products p where p.id='$id'";
$getProductById = $db->query($getProductByIdQuery);
$productData = mysqli_fetch_all($getProductById, MYSQLI_ASSOC);

?>

<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/get-product.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        <?php include('../CSS/get-product.css') ?>
    </style>
</head>
<body>
<div class="container" style="margin-top:50px">
    <?php
    foreach ($productData

    as $data):
    ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="main-container" style="margin-top:20px">
            <?php
            if (isset($errorMsg)) {
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        $errorMsg
                      </div>";
            }
            ?>
            <div class="details-container">
                <label>
                    Photo
                </label>
                <div>
                    <img src="../Assets/<?php echo $data['photo']; ?>" width="100" height="100" alt="">
                </div>
                <label>
                    Name
                </label>
                <div>
                    <?php echo $data['name'] ?>
                </div>
                <label>
                    Price
                </label>
                <div>
                    <?php echo $data['price'] ?>
                </div>
                <label>
                    Status
                </label>
                <div>
                    <?php echo $data['status'] ?>
                </div>
            </div>
        </div>
    </div>
    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 16px">
        <a href="../Products/EditProduct.php?id=<?php echo $id; ?>" title="Get products"
           style="float: right; text-decoration: none;">
            <button class="btn btn-light">
                Edit product
            </button>
        </a>
        <a href="../Products/GetProducts.php" title="Get products"
           style="float: right; text-decoration: none">
            <button class="btn btn-light">
                All products
            </button>
        </a>
    </div>
</div>
<?php endforeach; ?>
</body>
</html>


