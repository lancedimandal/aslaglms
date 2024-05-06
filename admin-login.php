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
    $password = $_POST['password'];

    // Check if the username and password match a record in the database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a user was found
    if ($user) {
        // Authentication successful
        // Redirect to the desired page or perform additional actions
        echo '<script>alert("Login successful"); window.location.href = "dashboard.php";</script>';
       
        exit;
    } else {
        // Authentication failed
        echo '<script>alert("Invalid username or password"); window.history.back();</script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/bootstrap/css/style.css">
    <title>Login</title>
</head>
<body>


    <div class="main">

        <div class="container">

            <form action="admin-login.php" method = "post">

                <img class = "ccsfplogo" src="..\admin\images\ccsfp.png" alt="CCSFP Logo">
                <h1>ADMIN LOGIN</h1>
                
                <div class = "input"> 
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class = "input"> 
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class = "check">
                <input type="checkbox" value="lsRememberMe" id="rememberMe" required> <label for="rememberMe">Remember me</label>
                <a id = "forgot" href="">Forgot Password?</a>
                </div>
             

                <div class = "sub"> 
                    <input type="submit" value="Login">
                </div>

                <div class = "txt-register">
                    <p>Not Registered yet?</p>
                    <a href="admin-register.php">Register</a>
                    <a id = "log" href="../index.html">Back</a>
                </div>

                

            </form>
        </div>
    </div>
    
</body>
</html>