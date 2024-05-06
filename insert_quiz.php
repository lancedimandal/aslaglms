<?php
require_once 'config/connection.php';
session_start();
date_default_timezone_set('Asia/Manila');
// Check if the teacher ID is set in the session
if (!isset($_SESSION['teacher_idnum'])) {

    echo 'Teacher ID not found. Please log in.';
    exit; // Stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the teacher ID from the session variable
    $teacherID = $_SESSION['teacher_idnum'];

    // Get the quiz details from the form
    $classId = $_POST['class_selection']; // The selected class ID from the dropdown
    $quizTitle = $_POST['quiz_title'];
    $quizDescription = $_POST['quiz_description'];
    $quizTimeLimit = $_POST['quiz_time_limit'];
    $totalpoints = $_POST['total_points'];
    $scheduled_time = $_POST['scheduled_time'];
   

    // Perform any additional validation or data processing here if needed

    // Insert the data into the quizzes table
    $insertQuery = "INSERT INTO quiz (teacher_id, class_id, quiz_title, quiz_description,total_points, quiz_time_limit, scheduled_time) 
                    VALUES (?, ?, ?,?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertQuery);

    // Assuming $teacherID and $classId are the teacher's ID and selected class ID
    mysqli_stmt_bind_param($stmt, "iissiis", $teacherID, $classId, $quizTitle, $quizDescription, $totalpoints, $quizTimeLimit, $scheduled_time);

    if (mysqli_stmt_execute($stmt)) {
        // Quiz added successfully, so set the response as "success" and show the modal
        echo "success";
    } else {
        
        echo "error: " . mysqli_error($connection);
    }

    mysqli_stmt_close($stmt); 
    mysqli_close($connection); 
    exit; // Stop further execution
}
?>
