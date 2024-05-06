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
    $assignTitle = $_POST['assignment_title'];
    $assignDesc = $_POST['assignment_description'];
    $assignDate = $_POST['assignment_date'];
    $classId = $_POST['class_selection']; // The selected class ID from the dropdown
    $total_points = $_POST['total_points'];
    $scheduled_time = $_POST['scheduled_time'];


    // Convert the input date to the 'Y-m-d H:i:s' format expected by the database
    $assignmentDateFormatted = date('Y-m-d H:i:s', strtotime($assignDate));

    // Query to insert data into the assignments table
    $insertQuery = "INSERT INTO assignments (assignment_title, assignment_description, scheduled_time, deadline, date_added, teacher_id, class_id,total_points) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertQuery);

    // Assuming $assignTitle, $assignDesc, $assignmentDateFormatted, $teacherID, and $classId are your variable values
    mysqli_stmt_bind_param($stmt, "sssssii", $assignTitle, $assignDesc, $scheduled_time,  $assignmentDateFormatted, $teacherID, $classId, $total_points);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Assignment added successfully
        echo "success";
    } else {
        // Error adding assignment
        echo "error";
    }
}
?>
