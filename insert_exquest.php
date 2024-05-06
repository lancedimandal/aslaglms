<?php

require_once 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the "Add Question" button was clicked
    if (isset($_POST['question_type'])) {
        $questionType = $_POST['question_type'];

        // Common Question Fields
        $question = $_POST['question'];

        // Initialize variables for the specific question type fields
        $choiceA = $choiceB = $choiceC = $choiceD = $correctAnswer = $essayFilePath = null;

        // Process the form data based on the question type
        if ($questionType === 'true_false') {
            // True/False Fields
            $studentAnswer = $_POST['student_answer'];
            $correctAnswer = $_POST['correct_answer'];
        } elseif ($questionType === 'multiple_choice') {
            // Multiple Choice Fields
            $choiceA = $_POST['choice_a'];
            $choiceB = $_POST['choice_b'];
            $choiceC = $_POST['choice_c'];
            $choiceD = $_POST['choice_d'];
            $correctAnswer = $_POST['correct_answer'];
        } elseif ($questionType === 'essay') {
            // Essay Fields
            // Here, you can handle the file upload and store the file path in $essayFilePath
            if (isset($_FILES['essay_file'])) {
                $file = $_FILES['essay_file'];
                $fileName = $file['name'];
                // Implement code to move the uploaded file to your desired location
                // For example: move_uploaded_file($file['tmp_name'], 'path/to/your/essay/files/' . $fileName);
                $essayFilePath = '/exam_file' . $fileName;
            }
        }

        // Now you can insert the data into the database based on the question type
        // Use prepared statements to prevent SQL injection
        $insertSql = "INSERT INTO exam_questions (exam_id, question_type, question_text, choice_a, choice_b, choice_c, choice_d, correct_answer, essay_file_path) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $insertSql);
        mysqli_stmt_bind_param($stmt, 'issssssss', $examId, $questionType, $question, $choiceA, $choiceB, $choiceC, $choiceD, $correctAnswer, $essayFilePath);

        // Replace $examId with the actual exam ID you want to associate the question with
        $examId = 1; // Replace with your exam ID

        if (mysqli_stmt_execute($stmt)) {
            // Question inserted successfully, redirect to the exam list page or display a success message.
            header('Location: teach-dash.php');
            exit();
        } else {
            // Handle the case where the insertion query fails.
            echo 'Error inserting question: ' . mysqli_error($connection);
        }
    }
}

?>