<?php
include '../Authentication/Config.php';
include '../Utils/StatusEnum.php';

date_default_timezone_set('Europe/Bucharest');
$date = date('Y/m/d', time());

if (isset($_POST['submit'])) {
    if (isset($_FILES['photo'])) {
        print_r($_FILES['photo']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "../Assets/" . $_FILES['photo']['name']);
        $name = $_POST['name'];
        $price = $_POST['price'];
        $photo = $_FILES['photo']['name'];
        echo $photo;
        $status = $_POST['status'];

        $edit = mysqli_query($db, "INSERT INTO products(name, price, photo, status) VALUES ('$name', '$price','$photo','$status' )");
        if ($edit) {
            mysqli_close($db);
            header("location:GetProducts.php");
            exit;
        } else {
            echo "Error creating record";
        }
    }
}


$outOfStock = ProductStatus::OUT_OF_STOCK;
$inStock = ProductStatus::IN_STOCK;
$runningLow = ProductStatus::RUNNING_LOW;

?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create new product</title>
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
    <h1 style="text-align: center;">Add new product</h1><br>
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
            <form action="CreateProduct.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>
                        Name
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Price
                        <input type="number" class="form-control" name="price" placeholder="Price">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Photo
                    </label>
                    <input type="file" name="photo" accept="image/png, image/jpeg">
                </div>
                <div class="form-group">
                    <label>Status
                        <select class="form-control" name="status">
                            <option value="<?php echo $outOfStock->getValue(); ?>">
                                <?php echo $outOfStock->getValue(); ?>
                            </option>
                            <option value="<?php echo $inStock->getValue(); ?>">
                                <?php echo $inStock->getValue(); ?>
                            </option>
                            <option value="
                            <?php echo $runningLow->getValue(); ?>">
                                <?php echo $runningLow->getValue(); ?>
                            </option>
                        </select>
                    </label>
                </div>
                <input type="submit" class="btn btn-warning btn btn-block" name="submit" value="Add Product">
            </form>
            <a href="GetProducts.php" title="All products"
               style="float: right; text-decoration: none; margin-top: 16px; width: inherit">
                <button class="btn btn-light btn btn-block">
                    See all products
                </button>
            </a>
        </div>
    </div>
</div>
</body>
</html>

