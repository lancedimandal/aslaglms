<?php 

session_start(); // Start the session
require_once ("config/connection.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input
    $studentid = $_POST['student_idnum'];
    $password = $_POST['password'];

    // Check if the username matches a record in the database
    $stmt = $connection->prepare("SELECT * FROM students WHERE student_idnum = ? AND password = ?");
    $stmt->bind_param('ss', $studentid,  $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if a user was found
    if ($user) {
        // Authentication successful
        // Store the teacher ID in a session variable
        $_SESSION['student_idnum'] = $user['student_idnum'];

        // Redirect to the desired page or perform additional actions
        echo '<script>alert("Login successful"); window.location.href = "stud-class-main.php";</script>';
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
    <link rel="stylesheet" href="./admin/bootstrap/css/student.css">
    <title>Login</title>
</head>
<body>


    <div class="main">

        <div class="container">
 <form action="student-login.php" method = "post" style = "width: 350px; height: 420px;">

                <img class = "ccsfplogo" src=".\admin\images\ccsfp.png" alt="CCSFP Logo">
                <h1>STUDENT LOGIN</h1>
                
                <div class = "input"> 
                    <input type="text" name="student_idnum" placeholder="Student ID " required>
                </div>

                <div class = "input"> 
                    <input type="password" name="password" placeholder="Password" required>
                </div>

             

                <div class = "sub"> 
                    <input type="submit" value="Login" style = "margin-top: 20px;">
                </div>

                <div style = "margin-left: 40px">

                    <a id = "log" href="index.html">Return to the login page</a>

                </div>

            </form>
        </div>
    </div>
    
</body>
</html>