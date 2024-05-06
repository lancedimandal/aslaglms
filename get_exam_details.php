<?php
// get_exam_details.php

require_once 'config/connection.php';


if (isset($_POST['exam_id'])) {
    $examId = $_POST['exam_id'];

    $sql = "SELECT * FROM exams WHERE exam_id = $examId";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Create an HTML representation of the exam details
        $examDetailsHTML = '<strong>Title:</strong> ' . $row['exam_title'] . '<br>';
        $examDetailsHTML .= '<strong>Description:</strong> ' . $row['exam_description'] . '<br>';
        $examDetailsHTML .= '<strong>Time Limit:</strong> ' . $row['exam_time_limit'] . ' Minutes <br>';
        $examDetailsHTML .= '<strong>Question Time Display:</strong> ' . $row['question_time_display'] . ' Seconds';

        // Return the HTML representation of the exam details
        echo $examDetailsHTML;
    } else {
        echo "Exam not found.";
    }
}
?>
?>
