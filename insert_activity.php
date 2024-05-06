<?php
require_once 'config/connection.php'; // Include your database connection here
session_start(); // Start the session

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

    // Retrieve the form data
    $actName = $_POST['activity_title'];
    $actDesc = $_POST['activity_description'];
    $actdate = $_POST['activity_date'];
    $classId = $_POST['class_selection']; // The selected class ID from the dropdown
    $totalpoints = $_POST['total_points'];
    $scheduled_time = $_POST['scheduled_time'];

    // Convert the input date to the 'YYYY-MM-DD HH:MI:SS' format expected by the database
    $activityDateFormatted = date('Y-m-d H:i:s', strtotime($actdate));

    // Query to insert data into the activities table
    $insertQuery = "INSERT INTO activities (activity_title, activity_description, scheduled_time,  deadline, teacher_idnum, class_id, total_points) VALUES (?, ?, ?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($connection, $insertQuery);

    // Assuming $actName, $actDesc, $activityDateFormatted, $teacherID, and $classId are your variable values
    mysqli_stmt_bind_param($stmt, "ssssiii", $actName, $actDesc,  $scheduled_time, $activityDateFormatted,  $teacherID, $classId, $totalpoints);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Activity added successfully
        echo "success";
    } else {
        // Error adding activity
        echo "error";
    }
}
?>
