<?php

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "aslaglms";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Insert form data into the database
    $stmt = $conn->prepare("INSERT INTO admin (username, fullname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $fullname, $email, $password]);

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Registration successful');</script>";
        echo "<script>window.location.href = 'admin-register.php';</script>";
    } else {
        echo "<script>alert('Error: Registration failed');</script>";
        echo "<script>window.location.href = 'admin-register.php';</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/bootstrap/css/register.css">
    <title>Registration</title>
</head>
<body>


    <form  class = "register" action="admin-register.php" method="POST">

        <h1>CREATE ACCOUNT</h1>
       
        <div class="form-group">

            <div class = "username">
                <label for="username">Username</label>
                <input type="text" class="form-control" name = "username" id="username" required>
            </div>
            
            <div class = "fullname">
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" class="form-control"  id="fullname" required>
            </div>

            <div class="email">

                <label for="email">Email Address</label>
                <input type="email" name = "email" class="form-control"  id = "email" required>
            </div>
            
           
            </div>
            
            <div class="password">
                <label for="password">Password</label>
                <input type="password" name = "password" class="form-control"  id = "password" required>
            </div>
           
            <div class="confirm">

                <label for="confirmpassword">Confirm Password</label>
                <input type="password" name = "confirmpassword" class="form-control"  id = "confirmpassword" required>  

            </div>

            
            <input type="submit" value = "sign up">

            <div class = "have"><p>Have an account? </p><a href="admin-login.php">Login</a></div>

        </div> 

    </form>
    
</body>
</html>