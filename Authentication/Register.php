<?php
session_start();

// initializing variables
$email = "";
$errors = array();

// connect to the database
$db = mysqli_connect('127.0.0.1:3306', 'root', '', 'ecommerce') or die('Unable To connect');

// REGISTER USER
if (count($_POST) > 0) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($full_name)) {
        array_push($errors, "Full name is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $hashed_password = password_hash($password_1, PASSWORD_DEFAULT); // encrypt

        $query = "INSERT INTO users (email, full_name, password, type) 
  			  VALUES('$email', '$full_name','$hashed_password', 'customer')";
        echo "<pre>Debug: $query</pre>\m";
        $result = mysqli_query($db, $query);
        if (false === $result) {
            printf("error: %s\n", mysqli_error($db));
        } else {
            echo 'done.';
        }
//        mysqli_query($db, $query);
        $_SESSION['email'] = $email;
        $_SESSION['type'] = 'customer';

        $_SESSION['success'] = "You are now logged in";
        header('location: Index.php');
    }
}
?>
<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/register.css?v=<?php echo time(); ?>" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        <?php include('../CSS/register.css') ?>
    </style>
</head>
<body>
<div class="container" style="margin-top:50px">
    <h1 style="text-align: center">Register</h1><br>
    <div class="row">
        <div class="child">
<!--            <div class="child" style="margin-top:20px; width: 300px">-->
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
                    <input type="text" class="form-control" name="full_name" placeholder="Full name"
                    >
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_1" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_2" placeholder="Confirm password">
                </div>
                <p>Already have an account? <a href="Login.php">Log In</a></p>
                <input type="submit" class="btn btn-warning btn btn-block" name="submit" value="Register">
            </form>
        </div>
    </div>
</div>
</body>
</html>
