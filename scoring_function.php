<?php

require 'config/connection.php';
// Function to calculate the total score for Multiple Choice questions
function calculateMultipleChoiceScore($submission)
{
    // Assuming you have a table called 'exam_questions' containing the questions and their types (multiple_choice or true_false)
    // Fetch the total score for Multiple Choice questions from the database
    // Here, $submission['exam_id'] refers to the exam ID associated with the submission
    $total_multiple_choice_score = 0;
    $stmt_get_multiple_choice_score = $connection->prepare("SELECT COUNT(*) AS total_score FROM exam_questions WHERE exam_id = ? AND question_type = 'multiple_choice'");
    $stmt_get_multiple_choice_score->bind_param("i", $submission['exam_id']);
    $stmt_get_multiple_choice_score->execute();
    $result = $stmt_get_multiple_choice_score->get_result();
    if ($row = $result->fetch_assoc()) {
        $total_multiple_choice_score = $row['total_score'];
    }
    $stmt_get_multiple_choice_score->close();

    // Calculate the student's total score for Multiple Choice questions
    $multiple_choice_score = ($submission['total_score_multiple_choice'] ?? 0);
    $multiple_choice_score = min($multiple_choice_score, $total_multiple_choice_score);

    return $multiple_choice_score;
}

// Function to calculate the total score for True/False questions
function calculateTrueFalseScore($submission)
{
    // Assuming you have a table called 'exam_questions' containing the questions and their types (multiple_choice or true_false)
    // Fetch the total score for True/False questions from the database
    // Here, $submission['exam_id'] refers to the exam ID associated with the submission
    $total_true_false_score = 0;
    $stmt_get_true_false_score = $connection->prepare("SELECT COUNT(*) AS total_score FROM exam_questions WHERE exam_id = ? AND question_type = 'true_false'");
    $stmt_get_true_false_score->bind_param("i", $submission['exam_id']);
    $stmt_get_true_false_score->execute();
    $result = $stmt_get_true_false_score->get_result();
    if ($row = $result->fetch_assoc()) {
        $total_true_false_score = $row['total_score'];
    }
    $stmt_get_true_false_score->close();

    // Calculate the student's total score for True/False questions
    $true_false_score = ($submission['total_score_true_false'] ?? 0);
    $true_false_score = min($true_false_score, $total_true_false_score);

    return $true_false_score;
}
