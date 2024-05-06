
<?php error_reporting(E_ALL & ~E_NOTICE); 
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabbed Navigation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-link {
            color: #495057;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            border-color: #007bff;
        }

        .tab-content {
            padding: 20px;
            border: 1px solid #dee2e6;
            border-top: none;
        }

        /* Example content styling */
        .tab-pane {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="exams-tab" data-bs-toggle="tab" href="#exams" role="tab" aria-controls="exams" aria-selected="true">Exams</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="quizzes-tab" data-bs-toggle="tab" href="#quizzes" role="tab" aria-controls="quizzes" aria-selected="false">Quizzes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="assignments-tab" data-bs-toggle="tab" href="#assignments" role="tab" aria-controls="assignments" aria-selected="false">Assignments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="activities-tab" data-bs-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="false">Activities</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="exams" role="tabpanel" aria-labelledby="exams-tab">
              <div id="exam-section" class="assessment-section">
                <h4>Exams Content</h4>
                <?php
                        require_once 'config/connection.php';

                        // Set the default timezone to Asia/Manila
                        date_default_timezone_set('Asia/Manila');

                        // Check if the student ID is set in the session
                        if (!isset($_SESSION['student_idnum'])) {
                            // Handle the case when the student ID is not set
                            echo 'Student ID not found. Please log in.';
                            exit; // Stop further execution
                        }

                        // Get the student ID from the session
                        $studentID = $_SESSION['student_idnum'];

                        // Check if the class ID is set in the URL parameter
                        if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
                            // Handle the case when the class ID is not provided or not numeric
                            echo 'Invalid class ID.';
                            exit; // Stop further execution
                        }

                        // Get the class ID from the URL parameter
                        $classID = $_GET['class_id'];

                        // Query to get the exams available for this class that the student has not taken and the scheduled time has passed
                        $sql = "SELECT e.exam_id, e.exam_title, e.exam_description, e.exam_time_limit
                                FROM exams e
                                WHERE e.class_id = ? AND NOT EXISTS (
                                    SELECT 1
                                    FROM student_taken_exams ste
                                    WHERE ste.exam_id = e.exam_id AND ste.student_id = ?
                                ) AND e.scheduled_time <= NOW()"; // This condition checks if the scheduled time has passed

                        // Prepare the statement
                        $stmt = mysqli_prepare($connection, $sql);

                        // Bind the class ID and student ID parameters to the prepared statement
                        mysqli_stmt_bind_param($stmt, "ii", $classID, $studentID);

                        // Execute the query
                        mysqli_stmt_execute($stmt);

                        // Get the result
                        $result = mysqli_stmt_get_result($stmt);

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                echo '<table class="table table-bordered">';
                                echo '<thead><tr><th>Exam Title</th><th>Exam Description</th><th>Time Limit</th><th>Action</th></tr></thead>';
                                echo '<tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $examID = $row['exam_id'];
                                    $examTitle = $row['exam_title'];
                                    $examDesc = $row['exam_description'];
                                    $examTimeLimit = $row['exam_time_limit'];

                                    echo '<tr>';
                                    echo '<td>' . $examTitle . '</td>';
                                    echo '<td>' . $examDesc . '</td>';
                                    echo '<td>' . $examTimeLimit . ' minutes</td>';
                                    echo '<td>';
                                    echo '<a class="btn btn-primary" href="view_exam.php?exam_id=' . $examID . '&class_id=' . $classID . '">Take Exam</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                echo '</tbody></table>';
                            } else {
                                echo '<p>No exams available.</p>';
                            }
                        } else {
                            // Error executing the prepared statement
                            echo '<p>Error executing the SQL query: ' . mysqli_error($connection) . '</p>';
                        }

                        // Close the prepared statement
                        mysqli_stmt_close($stmt);
                        ?>

                </div>
            </div>
            <div class="tab-pane fade" id="quizzes" role="tabpanel" aria-labelledby="quizzes-tab">
                <h4>Quizzes Content</h4>
                <?php

        date_default_timezone_set('Asia/Manila');
        require_once 'config/connection.php';

        // Check if the student ID is set in the session
        if (!isset($_SESSION['student_idnum'])) {
            // Handle the case when the student ID is not set
            // For example, redirect to a login page or display an error message
            echo 'Student ID not found. Please log in.';
            exit; // Stop further execution
        }

        // Get the student ID from the session
        $studentID = $_SESSION['student_idnum'];

        // Check if the class ID is set in the URL parameter
        if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
            // Handle the case when the class ID is not provided or not numeric
            echo 'Invalid class ID.';
            exit; // Stop further execution
        }

        // Get the class ID from the URL parameter
        $classID = $_GET['class_id'];

        // Query to get the quizzes available for this class that the student has not taken
        $sql = "SELECT e.quiz_id, e.quiz_title, e.quiz_description, e.quiz_time_limit
                                FROM quiz e
                                WHERE e.class_id = ? AND NOT EXISTS (
                                    SELECT 1
                                    FROM student_taken_quiz ste
                                    WHERE ste.quiz_id = e.quiz_id AND ste.student_id = ?
                                ) AND e.scheduled_time <= NOW()";

        // Prepare the statement
        $stmt = mysqli_prepare($connection, $sql);

        // Bind the class ID and student ID parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ii", $classID, $studentID);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead><tr><th>Quiz Title</th><th>Quiz Description</th><th>Time Limit</th><th>Action</th></tr></thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    $quizID = $row['quiz_id'];
                    $quizTitle = $row['quiz_title'];
                    $quizDesc = $row['quiz_description'];
                    $quizTimeLimit = $row['quiz_time_limit'];

                    echo '<tr>';
                    echo '<td>' . $quizTitle . '</td>';
                    echo '<td>' . $quizDesc . '</td>';
                    echo '<td>' . $quizTimeLimit . ' minutes</td>';
                    echo '<td>';
                    echo '<a class="btn btn-primary" href="view_quiz.php?quiz_id=' . $quizID . '&class_id=' . $classID . '">Take Quiz</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>No quizzes available.</p>';
            }
        } else {
            // Error executing the prepared statement
            echo '<p>Error executing the SQL query: ' . mysqli_error($connection) . '</p>';
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
        ?>
            </div>
            <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                <h4>Assignments Content</h4>
                <?php
require_once 'config/connection.php';
date_default_timezone_set('Asia/Manila');

// Check if the student ID is set in the session
if (!isset($_SESSION['student_idnum'])) {
    // Handle the case when the student ID is not set
    echo 'Student ID not found. Please log in.';
    exit; // Stop further execution
}

// Get the student ID from the session
$studentID = $_SESSION['student_idnum'];

// Check if the class ID is set in the URL parameter
if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
    // Handle the case when the class ID is not provided or not numeric
    echo 'Invalid class ID.';
    exit; // Stop further execution
}

// Get the class ID from the URL parameter
$classID = $_GET['class_id'];

// Query to get assignments available for this class that the student has not submitted and the scheduled_time has been reached
$sql = "SELECT a.assignment_id, a.assignment_title, a.assignment_description, 
               DATE_FORMAT(a.deadline, '%M %d, %Y %h:%i %p') AS formatted_deadline,
               TIMESTAMPDIFF(SECOND, NOW(), a.scheduled_time) AS time_difference_seconds
        FROM assignments a
        WHERE a.class_id = ? AND NOT EXISTS (
            SELECT 1
            FROM student_taken_assign sta
            WHERE sta.assignment_id = a.assignment_id AND sta.student_id = ?
        ) AND a.scheduled_time <= NOW()";

// Prepare the statement
$stmt = mysqli_prepare($connection, $sql);

// Bind the class ID and student ID parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "ii", $classID, $studentID);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>Assignment Title</th><th>Assignment Description</th><th>Deadline</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            $assignmentID = $row['assignment_id'];
            $assignmentTitle = $row['assignment_title'];
            $assignmentDesc = $row['assignment_description'];
            $deadline = $row['formatted_deadline'];

            echo '<tr>';
            echo '<td>' . $assignmentTitle . '</td>';
            echo '<td>' . $assignmentDesc . '</td>';
            echo '<td>' . $deadline . '</td>';
            echo '<td>';
            echo '<a class="btn btn-primary" href="view_assign.php?id=' . $assignmentID . '&class_id=' . $classID . '">View Assignment</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No assignments available.</p>';
    }
} else {
    // Error executing the prepared statement
    echo '<p>Error executing the SQL query: ' . mysqli_error($connection) . '</p>';
}

// Close the prepared statement
mysqli_stmt_close($stmt);
?>

            </div>
            <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                <h4>Activities Content</h4>

                <?php
                    require_once 'config/connection.php';
                    date_default_timezone_set('Asia/Manila');

                    // Check if the student ID is set in the session
                    if (!isset($_SESSION['student_idnum'])) {
                        // Handle the case when the student ID is not set
                        echo 'Student ID not found. Please log in.';
                        exit; // Stop further execution
                    }

                    // Get the student ID from the session
                    $studentID = $_SESSION['student_idnum'];

                    // Check if the class ID is set in the URL parameter
                    if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
                        // Handle the case when the class ID is not provided or not numeric
                        echo 'Invalid class ID.';
                        exit; // Stop further execution
                    }

                    // Get the class ID from the URL parameter
                    $classID = $_GET['class_id'];

                    // Query to get activities available for this class that the student has not submitted and the scheduled_time has been reached
                    $sql = "SELECT act.activity_id, act.activity_title, act.activity_description, 
                                DATE_FORMAT(act.deadline, '%M %d, %Y %h:%i %p') AS formatted_deadline,
                                TIMESTAMPDIFF(SECOND, NOW(), act.scheduled_time) AS time_difference_seconds
                            FROM activities act
                            WHERE act.class_id = ? AND NOT EXISTS (
                                SELECT 1
                                FROM student_taken_acts sta
                                WHERE sta.activity_id = act.activity_id AND sta.student_id = ?
                            ) AND act.scheduled_time <= NOW()";

                    // Prepare the statement
                    $stmt = mysqli_prepare($connection, $sql);

                    // Bind the class ID and student ID parameters to the prepared statement
                    mysqli_stmt_bind_param($stmt, "ii", $classID, $studentID);

                    // Execute the query
                    mysqli_stmt_execute($stmt);

                    // Get the result
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered">';
                            echo '<thead><tr><th>Activity Title</th><th>Activity Description</th><th>Deadline</th><th>Action</th></tr></thead>';
                            echo '<tbody>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                $activityID = $row['activity_id'];
                                $activityTitle = $row['activity_title'];
                                $activityDesc = $row['activity_description'];
                                $deadline = $row['formatted_deadline'];

                                echo '<tr>';
                                echo '<td>' . $activityTitle . '</td>';
                                echo '<td>' . $activityDesc . '</td>';
                                echo '<td>' . $deadline . '</td>';
                                echo '<td>';
                                echo '<a class="btn btn-primary" href="view_activity.php?id=' . $activityID . '&class_id=' . $classID . '">View Activity</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo '<p>No activities available.</p>';
                        }
                    } else {
                        // Error executing the prepared statement
                        echo '<p>Error executing the SQL query: ' . mysqli_error($connection) . '</p>';
                    }

                    // Close the prepared statement
                    mysqli_stmt_close($stmt);
                    ?>


            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
