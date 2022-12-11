<?php
session_start();
// Include database connectivity
include '../Authentication/Config.php';

if (isset($_POST['submit'])) {

    $errorMsg = "";

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!empty($email) || !empty($password)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['type'] = $row['type'];
                    $_SESSION['full_name'] = $row['full_name'];
                    header("Location:../Index.php");
                } else {
                    $errorMsg = "Email or Password is invalid";
                }
            }
        } else {
            $errorMsg = "No user found on this email";
        }
    } else {
        $errorMsg = "Email and Password is required";
    }
}

?>

<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" style="margin-top:50px">
    <h1 style="text-align: center;">Login</h1><br>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4" style="margin-top:20px; width: 300px">
            <?php
            if (isset($errorMsg)) {
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        $errorMsg
                      </div>";
            }
            ?>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <p>Are you new user? <a href="Register.php">Sign Up</a></p>
                <input type="submit" class="btn btn-warning btn btn-block" name="submit" value="Login">
            </form>
        </div>
    </div>
</div>
</body>
</html>
