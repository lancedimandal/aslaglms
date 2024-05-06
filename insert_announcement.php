<?php
require_once 'config/connection.php';
session_start();

// Check if the teacher ID is set in the session
if (!isset($_SESSION['teacher_idnum'])) {
    // Handle the case when the teacher ID is not set
    // For example, redirect to a login page or display an error message
    echo 'Teacher ID not found. Please log in.';
    exit; // Stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the teacher ID from the session variable
    $teacherID = $_SESSION['teacher_idnum'];

    // Get the announcement details from the form
    $classID = $_POST['class_selection']; // The selected class ID from the dropdown
    $announcementTitle = $_POST['announcement_title'];
    $announcementContent = $_POST['announcement_description'];
    $startDate = $_POST['announcement_start'];
    $expiryDate = $_POST['announcement_end'];

    // Perform any additional validation or data processing here if needed

    // Insert the data into the announcements table
    $insertQuery = "INSERT INTO announcements (teacher_id, class_id, title, content, start, expiry_date) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertQuery);

    // Assuming $teacherID and $classID are the teacher's ID and selected class ID
    $currentDate = date('Y-m-d H:i:s'); // Get the current date and time
    mysqli_stmt_bind_param($stmt, "iissss", $teacherID, $classID, $announcementTitle, $announcementContent, $startDate, $expiryDate);

    if (mysqli_stmt_execute($stmt)) {
        echo "success"; // Send a success response back to the AJAX request
    } else {
        echo "error". mysqli_error($connection); ; // Send an error response back to the AJAX request
    }
}
?>
