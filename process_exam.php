<?php
// Include the necessary database connection file
require_once 'config/connection.php';

// Check if the student ID is set in the session
if (!isset($_SESSION['student_idnum'])) {
    // Handle the case when the student ID is not set
    // For example, redirect to a login page or display an error message
    echo 'Student ID not found. Please log in.';
    exit; // Stop further execution
}

// Check if the exam ID is received through the form submission
if (isset($_POST['exam_id']) && is_numeric($_POST['exam_id'])) {
    $examID = $_POST['exam_id'];

    // Retrieve the student's answers from the form submission
    // Modify the code below based on the input names in the take_exam.php page
    // For example, if you used "name='question_1'" for the first question, then use $_POST['question_1'] to get the student's answer for that question
    // You may also need to validate and sanitize the input data
    $studentAnswers = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            $questionID = substr($key, strlen('question_'));
            $studentAnswers[$questionID] = $value;
        }
    }

    // Calculate the exam score (if applicable)
    // You'll need to compare the student's answers with the correct answers stored in the database (exam_questions table)
    // Implement your scoring logic based on your question types (e.g., multiple-choice, true/false, etc.)

    // Save the exam submission in the database (if required)
    // If you want to save the student's answers and score for future reference, you can insert them into a new table specific for exam submissions
    // For example, you can create a table named "exam_submissions" with columns like "submission_id", "student_id", "exam_id", "answers", "score", "submission_time", etc.

    // After processing the exam submission, you may want to redirect the student to a page showing the exam results or a thank-you message
    // For example, you can redirect the student to "exam_result.php" or "thank_you.php" using the header() function

    // Example code for redirection (uncomment the line below)
    // header('Location: exam_result.php');

} else {
    echo 'Exam ID not found.';
}
?>
