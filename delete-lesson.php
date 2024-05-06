<?php

require 'config/connection.php';

if (isset($_GET['class_id']) && isset($_GET['lesson_id'])) {
    $classID = $_GET['class_id'];
    $lessonID = $_GET['lesson_id'];

    // Delete the lesson
    $deleteQuery = "DELETE FROM lessons WHERE class_id = '$classID' AND lesson_id = '$lessonID'";
    if (mysqli_query($connection, $deleteQuery)) {
        // Deletion successful
        header("Location: view-class.php?class_id=" . $classID); // Redirect to the lessons page
        exit; 
    } else {
        // Deletion failed
        echo "Error deleting lesson: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    echo "Invalid parameters.";
}
?>
