<?php
include '../Authentication/Config.php';
include '../Utils/StatusEnum.php';
include '../Utils/Util.php';

getTimeZone();
$id = getId('GetProducts.php');

$productNameQuery = mysqli_query($db, "select name from products where id = '$id'");
$productName = mysqli_fetch_column($productNameQuery);
$productPriceQuery = mysqli_query($db, "select price from products where id = '$id'");
$productPrice = mysqli_fetch_column($productPriceQuery);
$productPhotoQuery = mysqli_query($db, "select photo from products where id = '$id'");
$productPhoto = mysqli_fetch_column($productPhotoQuery);
$productStatusQuery = mysqli_query($db, "select status from products where id = '$id'");
$productStatus = mysqli_fetch_row($productStatusQuery);

$outOfStock = ProductStatus::OUT_OF_STOCK;
$inStock = ProductStatus::IN_STOCK;
$runningLow = ProductStatus::RUNNING_LOW;

$typeOfStatus = array($outOfStock->getValue(), $inStock->getValue(), $runningLow->getValue());
$currentStatus = getStatusValue($productStatus[0], $typeOfStatus);
$statusArray = deleteCurrentStatus($productStatus[0], $typeOfStatus);

$outOfStock = $typeOfStatus[0];
$inStock = $typeOfStatus[1];
$runningLow = $typeOfStatus[2];

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $photo = $_POST['photo'];
    if (isset($_FILES['photo'])) {
        print_r($_FILES['photo']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "../Assets/" . $_FILES['photo']['name']);
        $photo = $_FILES['photo']['name'];
        $edit = mysqli_query($db, "update products set name='$name', price='$price', photo='$photo', status='$status' where id = '$id'");
    } else {
        $edit = mysqli_query($db, "update products set name='$name', price='$price', photo='$photo, status='$status' where id = '$id'");
    }
    if ($edit) {
        mysqli_close($db); // Close connection
        header("location:GetProducts.php"); // redirects to all records page
        exit;
    } else {
        echo "Error deleting record"; // display error message if not delete
    }
}

?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/edit-product.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        <?php include('../CSS/edit-product.css') ?>
    </style>
</head>
<body>
<div class="container" style="margin-top:50px">
    <h1 style="text-align: center;">Edit product</h1><br>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4" style="margin-top:20px">
            <?php
            if (isset($errorMsg)) {
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        $errorMsg
                      </div>";
            }
            ?>
            <form action="" method="POST" class="form-container" enctype="multipart/form-data">
                <label>
                    Name
                    <input type="text" class="form-control" name="name" required value=<?php echo $productName ?>>
                </label>
                <label>
                    Price
                    <input type="number" class="form-control" name="price" required value=<?php echo $productPrice ?>>
                </label>
                <label>
                    Photo
                </label>
                <img src="../Assets/<?php echo $productPhoto; ?>" width="100" height="100" alt="No photo">
                <input type="file" name="photo" accept="image/png, image/jpeg">
                <label>
                    Status
                    <select class="form-control" name="status">
                        <option value="<?php echo $currentStatus ?>">
                            <?php echo $currentStatus; ?>
                        </option>
                        <?php
                        foreach ($statusArray as $status) : ?>
                            <option value="<?= $status; ?>">
                                <?php echo $status; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <input type="submit" class="btn btn-warning btn btn-block" name="submit" value="Edit product">
            </form>
        </div>
    </div>
</div>
</body>
</html>

