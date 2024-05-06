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

    <title>Quiz Results</title>
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

// Check if the quiz ID and score are set in the URL parameters
if (isset($_GET['quiz_id']) && is_numeric($_GET['quiz_id']) && isset($_GET['score']) && is_numeric($_GET['score'])) {
    $quizID = $_GET['quiz_id'];
    $score = $_GET['score'];

    // Retrieve quiz details
    $sql_quiz_details = "SELECT quiz_title, quiz_description, class_id FROM quiz WHERE quiz_id = ?";
    $stmt_quiz_details = mysqli_prepare($connection, $sql_quiz_details);
    mysqli_stmt_bind_param($stmt_quiz_details, "i", $quizID);
    mysqli_stmt_execute($stmt_quiz_details);
    $result_quiz_details = mysqli_stmt_get_result($stmt_quiz_details);

    if ($row_quiz_details = mysqli_fetch_assoc($result_quiz_details)) {
        $quizTitle = $row_quiz_details['quiz_title'];
        $quizDescription = $row_quiz_details['quiz_description'];
        $classID = $row_quiz_details['class_id'];
    } else {
        die('Quiz details not found.');
    }

    // Retrieve student's answers and corresponding questions, correct answers
    $sql_student_answers = "SELECT sa.question_id, q.question_text, sa.answer, q.correct_answer FROM student_quiz_answers sa 
    INNER JOIN quiz_questions q ON sa.question_id = q.question_id 
    WHERE sa.quiz_id = ? AND sa.student_id = ?";
    $stmt_student_answers = mysqli_prepare($connection, $sql_student_answers);
    mysqli_stmt_bind_param($stmt_student_answers, "ii", $quizID, $_SESSION['student_idnum']);
    mysqli_stmt_execute($stmt_student_answers);
    $result_student_answers = mysqli_stmt_get_result($stmt_student_answers);

    $sql_total_points = "SELECT total_points FROM quiz WHERE quiz_id = ?";
    $stmt_total_points = mysqli_prepare($connection, $sql_total_points);
    mysqli_stmt_bind_param($stmt_total_points, "i", $quizID);
    mysqli_stmt_execute($stmt_total_points);
    $result_total_points = mysqli_stmt_get_result($stmt_total_points);
    $row_total_points = mysqli_fetch_assoc($result_total_points);
    $totalPoints = $row_total_points['total_points'];

    // Display the results, including the score
    echo '<div class="container mt-4">';
    echo '<h1 class="lead">Quiz Results: ' . $quizTitle . '</h1>';
    echo '<p style="text-align: center;">Quiz Description: ' . $quizDescription . '</p>';
    echo '<p style="text-align: center;">Your score: <strong>' . $score . '/' . $totalPoints . '</strong></p>';

    echo '<h2 class="mt-2">Your Answers:</h2>';
    echo '<ul class="list-group">';
    while ($row_student_answers = mysqli_fetch_assoc($result_student_answers)) {
        $questionText = $row_student_answers['question_text'];
        $studentAnswer = $row_student_answers['answer'];
        $correctAnswer = $row_student_answers['correct_answer'];
        $classID = $row_quiz_details['class_id'];
        $answerStatus = ($studentAnswer === $correctAnswer) ? 'correct-answer' : 'incorrect-answer';
        
        echo '<li class="list-group-item">';
        echo '<p class="question-text"><strong>Question: </strong>' . $questionText . '</p>';
        echo '<p><strong>Your Answer: </strong><span class="' . $answerStatus . '">' . $studentAnswer . ' (<span class="answer-status">' . ucfirst($answerStatus) . '</span>)</span></p>';
        echo '<p><strong>Correct Answer: </strong>' . $correctAnswer . '</p>';
        echo '</li>';
    }
    echo '</ul>';

    echo '<a class="btn btn-primary mt-3" href="stud-dash.php?class_id=' . $classID . '">Back to Dashboard</a>';

    echo '</div>';
} else {
    echo 'Invalid URL parameters. Please ensure you have completed the quiz.';
}
?>

</body>
</html>
