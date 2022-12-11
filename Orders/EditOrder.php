<?php
include '../Authentication/Config.php';
include '../Utils/StatusEnum.php';
include '../Utils/Util.php';

$orderId = getId("GetOrders.php");

$orderStatusQuery = mysqli_query($db, "select status from orders where id = '$orderId'");
$orderStatus = mysqli_fetch_row($orderStatusQuery);

$pending = OrderStatus::PENDING;
$cancelled = OrderStatus::CANCELLED;
$declined = OrderStatus::DECLINED;
$delivered = OrderStatus::DELIVERED;
$refunded = OrderStatus::REFUNDED;

$typeOfStatus = array($pending->getValue(), $cancelled->getValue(), $declined->getValue(), $delivered->getValue(), $refunded->getValue());
$currentStatus = getStatusValue($orderStatus[0], $typeOfStatus);
$statusArray = deleteCurrentStatus($orderStatus[0], $typeOfStatus);


if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    echo $status;
    $edit = mysqli_query($db, "update orders set status='$status' where id = '$orderId'");
    if ($edit) {
        mysqli_close($db); // Close connection
        header("location:GetOrders.php"); // redirects to all records page
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
    <title>Edit order status</title>
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
    <h1 style="text-align: center;">Edit order status</h1><br>
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
            <form action="" method="POST" class="form-container">
                <label>Status
                    <select class="form-control" name="status">
                        <option value="<?php echo $currentStatus ?>">
                            <?php echo $currentStatus; ?>
                        </option>
                        <?php
                        foreach ($statusArray as $s) : ?>
                            <option value="<?= $s; ?>">
                                <?php echo $s; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <input type="submit" class="btn btn-warning btn btn-block" name="submit" value="Edit Product">
            </form>
        </div>
    </div>
</div>
</body>
</html>

