<?php
// Include the database connection configuration
require 'config/connection.php';

// Get data from the form submission
$subject_id = $_POST['subject_id'];
$year = $_POST['year'];
$course = $_POST['course'];
$section = $_POST['section'];
$block = $_POST['block'];

// Insert class details into the student_list table
$insert_query = "INSERT INTO student_list (subject_id, year, course, section, block) VALUES ('$subject_id', '$year', '$course', '$section', '$block')";

if (mysqli_query($connection, $insert_query)) {
    // Class details inserted successfully, now initiate student enrollment logic
    include 'enroll_students.php'; // This file should contain your enrollment logic
    echo "Class created and students enrolled successfully.";
} else {
    echo "Error creating class: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
