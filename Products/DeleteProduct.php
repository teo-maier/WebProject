<?php
include '../Authentication/Config.php';

$id = $_GET['id'];
$del = mysqli_query($db, "delete from products where id = '$id'"); // delete query
if ($del) {
    mysqli_close($db); // Close connection
    header("location:GetProducts.php"); // redirects to all records page
    exit;
} else {
    echo "Error deleting record"; // display error message if not delete
}
?>