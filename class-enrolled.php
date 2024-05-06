<?php

require 'config/connection.php';

$response = array(); // Create an array to store the response data

if (isset($_POST['enroll_student'])) {
    // Get the student ID from the form submission
    $studentID = $_POST['student_id'];

    // Get the class ID from the session variable
    session_start();
    if (isset($_SESSION['class_id'])) {
        $classID = $_SESSION['class_id'];

        // Check if the student is already enrolled in the class
        $selectQuery = "SELECT * FROM student_classes WHERE student_id = ? AND class_id = ?";
        $stmt = mysqli_prepare($connection, $selectQuery);
        mysqli_stmt_bind_param($stmt, "ii", $studentID, $classID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Student is already enrolled in the class.';
        } else {
            // Enroll the student in the class
            $insertQuery = "INSERT INTO student_classes (student_id, class_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($connection, $insertQuery);
            mysqli_stmt_bind_param($stmt, "ii", $studentID, $classID);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Student enrolled successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to enroll student. Please try again.';
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Class ID not found.';
    }

    // Close the database connection
    mysqli_close($connection);

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
