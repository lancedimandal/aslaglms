<?php
require 'config/connection.php';

// Check if the teacher ID exists in the URL
if (isset($_GET['teacher_id']) && is_numeric($_GET['teacher_id'])) {
    $teacherID = $_GET['teacher_id'];
} else {
    echo "Invalid teacher ID!";
    exit;
}

// Assuming you have a form or confirmation logic for deleting the profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission and delete the profile from the database
    $deleteQuery = "DELETE FROM teachers WHERE teacher_idnum = ?";
    $stmt = mysqli_prepare($connection, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $teacherID);
    if (mysqli_stmt_execute($stmt)) {
        // Deletion successful, you can redirect to a success page or show a success message
        header("Location: delete-success.php");
        exit;
    } else {
        echo "Error deleting profile: " . mysqli_error($connection);
    }
}

// Fetch the current teacher's information from the database
$selectQuery = "SELECT * FROM teachers WHERE teacher_idnum = ?";
$stmt = mysqli_prepare($connection, $selectQuery);
mysqli_stmt_bind_param($stmt, "i", $teacherID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Profile</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Delete Profile</h2>
        <p>Are you sure you want to delete your profile?</p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Delete Profile</button>
        </form>
    </div>
</body>
</html>
