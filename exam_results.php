<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/bootstrap/css/admin-dash.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-f4KbD4SDf9L41ZEn1Ktz9v/gJOzZwLC4lF6CQG1tO3t24SkAAsYB55rDzGc+3gV97jby0JJxJ3j7XTa6Q/vg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Exam Results</title>
</head>
<body>
<style>
        body {
            background-color: #f8f9fa;
            
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .result-heading {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .lead {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
        }
        .question-text {
            font-size: 18px;
        }
        .answer-status {
            font-size: 16px;
            font-weight: bold;
        }
        .correct-answer {
            color: #28a745;
        }
        .incorrect-answer {
            color: #dc3545;
        }
        .invalid-message {
            font-size: 18px;
            color: #dc3545;
            font-weight: bold;
        }
    </style>
<?php

require_once 'config/connection.php'; 
session_start();

// Check if the exam ID and score are set in the URL parameters
if (isset($_GET['exam_id']) && is_numeric($_GET['exam_id']) && isset($_GET['score']) && is_numeric($_GET['score'])) {
    $examID = $_GET['exam_id'];
    $score = $_GET['score'];

    $sql_exam_details = "SELECT exam_title, exam_description, exam_time_limit, class_id FROM exams WHERE exam_id = ?";
    $stmt_exam_details = mysqli_prepare($connection, $sql_exam_details);
    mysqli_stmt_bind_param($stmt_exam_details, "i", $examID);
    mysqli_stmt_execute($stmt_exam_details);
    $result_exam_details = mysqli_stmt_get_result($stmt_exam_details);

    if ($row_exam_details = mysqli_fetch_assoc($result_exam_details)) {
        $examTitle = $row_exam_details['exam_title'];
        $examDescription = $row_exam_details['exam_description'];
        $examTimeLimit = $row_exam_details['exam_time_limit'];
        $classID = $row_exam_details['class_id'];
    } else {
        die('Exam details not found.');
    }

    // Retrieve student's answers and corresponding questions, correct answers, and class_id
    $sql_student_answers = "SELECT sa.question_id, q.question_text, sa.answer, q.correct_answer, sa.class_id FROM student_answers sa 
    INNER JOIN exam_questions q ON sa.question_id = q.question_id 
    WHERE sa.exam_id = ? AND sa.student_id = ?";
    $stmt_student_answers = mysqli_prepare($connection, $sql_student_answers);
    mysqli_stmt_bind_param($stmt_student_answers, "ii", $examID, $_SESSION['student_idnum']);
    mysqli_stmt_execute($stmt_student_answers);
    $result_student_answers = mysqli_stmt_get_result($stmt_student_answers);

    $sql_total_points = "SELECT total_points FROM exams WHERE exam_id = ?";
    $stmt_total_points = mysqli_prepare($connection, $sql_total_points);
    mysqli_stmt_bind_param($stmt_total_points, "i", $examID);
    mysqli_stmt_execute($stmt_total_points);
    $result_total_points = mysqli_stmt_get_result($stmt_total_points);
    $row_total_points = mysqli_fetch_assoc($result_total_points);
    $totalPoints = $row_total_points['total_points'];

    // Display the results, including the score
    echo '<div class="container mt-4">';
    echo '<h1 class="lead">Exam Results: ' . $examTitle . '</h1>';
            echo '<p style = " text-align: center;">Exam Description: ' . $examDescription . '</p>';
            echo '<p style = " text-align: center;">Time Limit: ' . $examTimeLimit . ' minutes</p>';
            echo '<p style = " text-align: center;">Your score: <strong>' . $score . '/' . $totalPoints . '</strong></p>';

            echo '<h2 class="mt-2">Your Answers:</h2>';
            echo '<ul class="list-group">';
            while ($row_student_answers = mysqli_fetch_assoc($result_student_answers)) {
                $questionID = $row_student_answers['question_id'];
                $questionText = $row_student_answers['question_text'];
                $studentAnswer = $row_student_answers['answer'];
                $correctAnswer = $row_student_answers['correct_answer'];
                $classID = $row_student_answers['class_id'];

                $answerStatus = ($studentAnswer === $correctAnswer) ? 'correct-answer' : 'incorrect-answer';
                
                echo '<li class="list-group-item">';
                echo '<p class="question-text"><strong>Question: </strong>' . $questionText . '</p>';
                echo '<p><strong>Your Answer: </strong><span class="' . $answerStatus . '">' . $studentAnswer . ' (<span class="answer-status">' . ucfirst($answerStatus) . '</span>)</span></p>';
                echo '<p><strong>Correct Answer: </strong>' . $correctAnswer . '</p>';
                echo '</li>';
                
            }

            echo '<a class="btn btn-primary mt-3" href="stud-dash.php?class_id=' . $classID . '">Back to Dashboard</a>';

    echo '</ul>';
    echo '</div>';
} else {
    echo 'Invalid URL parameters. Please ensure you have completed the exam.';
}
?>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-HiHqnUOlRfz7jQKk/UCdECLFuxreLM0kca/S9nU+1FL7AKPHb8lFTX1MHpwr/4P6T0ys/Sp4AyStjPNQkqaHg==" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
</body>
</html>
