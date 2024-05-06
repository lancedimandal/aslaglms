<?php
require_once 'config/connection.php'; // Include your database connection here
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

    // Get the exam details from the form   
    $classId = $_POST['class_selection']; // The selected class ID from the dropdown
    $examTitle = $_POST['exam_title'];
    $examDescription = $_POST['exam_description'];
    $examTimeLimit = $_POST['exam_time_limit'];
    $total_points = $_POST['total_points'];
    $scheduled_time = $_POST['scheduled_time'];

    // Perform any additional validation or data processing here if needed

    // Insert the data into the exams table
    $insertQuery = "INSERT INTO exams (teacher_id, class_id, exam_title, exam_description, exam_time_limit, scheduled_time, total_points) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertQuery);

    // Assuming $teacherID and $classId are the teacher's ID and selected class ID
    mysqli_stmt_bind_param($stmt, "iissisi", $teacherID, $classId, $examTitle, $examDescription, $examTimeLimit, $scheduled_time, $total_points);

    if (mysqli_stmt_execute($stmt)) {
        /*
        require 'run_notifications.php';
        */
        echo "success"; // Send a success response back to the AJAX request
       
    } else {
        echo "error" . mysqli_error($connection); // Send an error response back to the AJAX request
    }
}
?>
