<?php
// Assuming you have the necessary database connection code
require_once 'config/connection.php';

// Retrieve the class_id from the URL parameter
if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];

    // Retrieve the class details from the database
    $selectQuery = "SELECT class_name, subject FROM classes WHERE class_id = ?";
    $stmt = mysqli_prepare($connection, $selectQuery);
    mysqli_stmt_bind_param($stmt, "i", $classID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the class details as an associative array
        $classDetails = mysqli_fetch_assoc($result);

        // Output the class details
        echo '<div class="class-details">';
        echo '<h2>' . $classDetails['class_name'] . '</h2>';
        echo '<p>Subject: ' . $classDetails['subject'] . '</p>';

        // Display the options to add quizzes, exams, activities, and assignments
        echo '<div class="options">';
        echo '<a href="add-quiz.php?class_id=' . $classID . '">Add Quiz</a>';
        echo '<a href="add-exam.php?class_id=' . $classID . '">Add Exam</a>';
        echo '<a href="add-activity.php?class_id=' . $classID . '">Add Activity</a>';
        echo '<a href="add-assignment.php?class_id=' . $classID . '">Add Assignment</a>';
        echo '</div>';
        echo '</div>'; // Close the class-details div
    } else {
        echo 'Class not found.';
    }
} else {
    echo 'Class ID not provided.';
}
?>



<style>
    .class-details {
        background-color: #f2f2f2;
        padding: 10px;
        margin-top: 10px;
    }

    .class-name {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .subject {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .options a {
        display: block;
        margin-bottom: 5px;
    }
</style>
